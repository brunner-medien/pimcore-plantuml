<?php

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class ConfigurationService implements ConfigurationServiceInterface
{

    /**
     * @var Model\FactoryInterface;
     */
    protected $modelFactory;

    /**
     * @var string
     */
    protected $configDirectory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param Model\FactoryInterface $modelFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        Model\FactoryInterface $modelFactory,
        Filesystem $filesystem
    )
    {
        $this->modelFactory = $modelFactory;
        $this->filesystem = $filesystem;
        $this->configDirectory = PIMCORE_PRIVATE_VAR . '/bundles/PlantUmlBundle/config';
    }

    /**
     * Setter dependency injection
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->config['templates'];
    }

    /**
     * @param string $templateName
     * @return string
     * @throws \Exception
     */
    public function getTemplatePath(string $templateName)
    {
        if (!array_key_exists($templateName, $this->config['templates'])) {
            throw new \Exception('Template has no path specified');
        }

        return $this->config['templates'][$templateName]['path'];
    }

    /**
     * @return array
     */
    public function listConfig()
    {
        $configs = [];
        $finder = new Finder();

        try {
            $finder->files()->in($this->getConfigDirectory())->name('*.yml');
            foreach ($finder as $file) {
                $configs[] = [
                    'name' => $file->getBasename('.yml')
                ];
            }
        } catch (\Exception $e) {
            // do nothing - just return an empty list
        }

        return $configs;
    }

    /**
     * @param string $name
     * @return Model\ConfigInterface
     * @throws \Exception
     */
    public function getConfig(string $name)
    {
        $this->checkConfigName($name);

        $configFile = sprintf('%s/%s.yml', $this->getConfigDirectory(), $name);
        if (!$this->filesystem->exists($configFile)) {
            throw new \Exception('Configuration does not exist');
        }

        $config = $this->modelFactory->buildConfig();
        $config->fromArray((array) Yaml::parse(file_get_contents($configFile)));

        return $config;
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    public function deleteConfig(string $name)
    {
        $this->checkConfigName($name);

        $configFile = sprintf('%s/%s.yml', $this->getConfigDirectory(), $name);
        if (!$this->filesystem->exists($configFile)) {
            throw new \Exception('Configuration does not exist');
        }
        $this->filesystem->remove($configFile);
    }

    /**
     * @param string $name
     * @param array $payload
     * @param bool $ignoreExisting
     * @throws \Exception
     */
    public function saveConfig(string $name, array $payload, bool $ignoreExisting)
    {
        $this->checkConfigName($name);

        $configFile = sprintf('%s/%s.yml', $this->getConfigDirectory(), $name);
        if (!$ignoreExisting && $this->filesystem->exists($configFile)) {
            throw new \Exception('Configuration already exists');
        }

        $config = $this->modelFactory->buildConfig();
        $config->fromArray($payload);
        $this->filesystem->dumpFile($configFile, Yaml::dump($config->toArray()));
    }

    /**
     * @param $name
     * @throws \Exception
     */
    public function checkConfigName($name)
    {
        if (!is_string($name) || !preg_match('/^[0-9a-zA-Z_\-]+$/', $name)) {
            throw new \Exception('Illegal config name');
        }
    }

    /**
     * @return string
     */
    protected function getConfigDirectory()
    {
        if ($this->filesystem->exists($this->configDirectory)) {
            $this->filesystem->mkdir($this->configDirectory);
        }

        return $this->configDirectory;
    }

}