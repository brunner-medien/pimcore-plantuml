<?php

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;
use Pimcore\Model\Tool\SettingsStore;

class ConfigurationService implements ConfigurationServiceInterface
{

    /**
     * @var string
     */
    const IDENTIFIER = 'plantuml';

    /**
     * @var Model\FactoryInterface;
     */
    protected Model\FactoryInterface $modelFactory;

    /**
     * @var array
     */
    protected array $configuration = [];

    /**
     * @param Model\FactoryInterface $modelFactory
     */
    public function __construct(Model\FactoryInterface $modelFactory)
    {
        $this->modelFactory = $modelFactory;
    }

    /**
     * Setter dependency injection
     *
     * @param array $configuration
     */
    public function setConfig(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->configuration['templates'];
    }

    /**
     * @param string $templateName
     * @return string
     * @throws \Exception
     */
    public function getTemplatePath(string $templateName)
    {
        if (!array_key_exists($templateName, $this->configuration['templates'])) {
            throw new \Exception('Template has no path specified');
        }

        return $this->configuration['templates'][$templateName]['path'];
    }

    /**
     * @return string
     */
    public function getRenderUrl()
    {
        return (string) $this->configuration['render_url'];
    }

    /**
     * @return array
     */
    public function listConfig(): array
    {
        $configs = [];

        $ids = SettingsStore::getIdsByScope(self::IDENTIFIER);
        try {
            foreach ($ids as $id) {
                $configs[] = [
                    'name' => $this->getConfigName($id)
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
    public function getConfig(string $name): Model\ConfigInterface
    {
        $this->checkConfigName($name);

        $id = $this->getConfigId($name);
        if (!$settings = SettingsStore::get($id, self::IDENTIFIER)) {
            throw new \Exception('Configuration does not exist');
        }
        $configString = $settings->getData();

        $config = $this->modelFactory->buildConfig();
        $config->fromArray((array) json_decode($configString, true));

        return $config;
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    public function deleteConfig(string $name)
    {
        $this->checkConfigName($name);

        $id = $this->getConfigId($name);
        if (!SettingsStore::get($id, self::IDENTIFIER)) {
            throw new \Exception('Configuration does not exist');
        }

        SettingsStore::delete($id, self::IDENTIFIER);
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

        $id = $this->getConfigId($name);
        if (!$ignoreExisting && $existing = SettingsStore::get($id, self::IDENTIFIER)) {
            throw new \Exception('Configuration already exists');
        }

        // normalize config
        $config = $this->modelFactory->buildConfig();
        $config->fromArray($payload);

        SettingsStore::set($id, json_encode($config->toArray()), 'string', self::IDENTIFIER);
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

    protected function getConfigId(string $name)
    {
        return sprintf("%s:%s", self::IDENTIFIER, $name);
    }

    protected function getConfigName(string $id)
    {
        return substr($id, strlen(self::IDENTIFIER) + 1);
    }

}
