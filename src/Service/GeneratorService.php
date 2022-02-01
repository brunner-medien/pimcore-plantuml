<?php

declare(strict_types=1);

namespace PlantUmlBundle\Service;

use Pimcore\Model\DataObject;
use PlantUmlBundle\Generator;
use PlantUmlBundle\Model;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Registry\RegistryInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment as Twig;

class GeneratorService implements GeneratorServiceInterface
{
    /**
     * @var Generator\FactoryInterface
     */
    protected $generatorFactory;

    /**
     * @var Model\FactoryInterface;
     */
    protected $modelFactory;

    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var ConfigurationServiceInterface
     */
    protected $configurationService;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Twig
     */
    protected $twig;

    public function __construct(
        Generator\FactoryInterface $generatorFactory,
        Model\FactoryInterface $modelFactory,
        RegistryInterface $registry,
        ConfigurationServiceInterface $configurationService,
        Filesystem $filesystem,
        Twig $twig
    ) {
        $this->generatorFactory = $generatorFactory;
        $this->modelFactory = $modelFactory;
        $this->registry = $registry;
        $this->configurationService = $configurationService;
        $this->filesystem = $filesystem;
        $this->twig = $twig;
    }

    /**
     * @return RegistryInterface
     */
    public function loadRegistry(Model\ConfigInterface $config = null)
    {
        $this->registry->reset();

        $list = new DataObject\ClassDefinition\Listing();
        foreach ($list->getClasses() as $classDefinition) {
            $namespaceName = Model\AbstractModel::generateNamespaceName(
                [ModelInterface::CLASS_OBJECT],
                $classDefinition->getName()
            );
            $active = $config && $config->getClassSeed($namespaceName);
            $generator = $this->generatorFactory->buildGenerator($classDefinition);
            $generator->generate([ModelInterface::CLASS_OBJECT], $active);
        }

        $list = new DataObject\Fieldcollection\Definition\Listing();
        foreach ($list->load() as $fieldDefinition) {
            $generator = $this->generatorFactory->buildGenerator($fieldDefinition);
            $generator->generate([ModelInterface::CLASS_FIELD_COLLECTION], false);
        }

        $list = new DataObject\Classificationstore\GroupConfig\Listing();
        foreach ($list->load() as $groupConfig) {
            $generator = $this->generatorFactory->buildGenerator($groupConfig);
            $generator->generate([ModelInterface::CLASS_CLASSIFICATION], false);
        }

        $list = new DataObject\Objectbrick\Definition\Listing();
        foreach ($list->load() as $objectBrickDefinition) {
            $generator = $this->generatorFactory->buildGenerator($objectBrickDefinition);
            $generator->generate([ModelInterface::CLASS_OBJECT_BRICK], false);
        }

        return $this->registry;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generate(Model\ConfigInterface $config, string $name)
    {
        $registry = $this->loadRegistry($config);
        $templateName = $config->getTemplate();
        $templatePath = $this->configurationService->getTemplatePath($templateName);

        $classes = $this->getFilteredClasses($registry->getClasses(), $config);
        $relations = $this->getFilteredRelations($registry->getRelations(), $classes);

        $puml = $this->twig->render("$templatePath/template.puml.twig", [
            'classes' => $classes,
            'relations' => $relations,
            'config' => $config,
            'templatePath' => $templatePath,
            'translation' => $config->getTranslation(),
        ]);

        if ($outputPath = $config->getOutputPath()) {
            if (substr($outputPath, 0, 1) === '/') {
                $absoluteOutputPath = $outputPath;
            } else {
                $absoluteOutputPath = sprintf('%s/%s', PIMCORE_PROJECT_ROOT, $outputPath);
            }
            $this->filesystem->mkdir($absoluteOutputPath);
            $absoluteFileName = sprintf('%s/%s.puml', $absoluteOutputPath, $name);
            file_put_contents($absoluteFileName, $puml);
        }

        return $puml;
    }

    /**
     * @param Model\ClassInterface[] $classes
     *
     * @return Model\ClassInterface[]
     */
    protected function getFilteredClasses(array $classes, Model\ConfigInterface $config)
    {
        $filter = function (Model\ClassInterface $class) use ($config) {
            $mode = $config->getClassMode($class->getNamespaceName());
            if ($mode === Model\ConfigInterface::CLASS_MODE_FORCE) {
                return true;
            }
            if ($mode === Model\ConfigInterface::CLASS_MODE_SKIP) {
                return false;
            }
            return $class->getIsActive();
        };

        $filteredClasses = array_filter($classes, $filter);

        foreach ($filteredClasses as $class) {
            $realizeClasses = array_filter($class->getRealizeClasses(), $filter);
            $class->setRealizeClasses($realizeClasses);

            if ($generalizeClass = $class->getGeneralizeClass()) {
                if (! $filter($generalizeClass)) {
                    $class->setGeneralizeClass(null);
                }
            }
        }

        return $filteredClasses;
    }

    /**
     * @param Model\RelationInterface[] $relations
     * @param Model\ClassInterface[] $classes
     */
    protected function getFilteredRelations(array $relations, array $classes)
    {
        $filter = function (Model\RelationInterface $relation) use ($classes) {
            if (! in_array($relation->getLocalClass(), $classes, true)) {
                return false;
            }
            if (! in_array($relation->getForeignClass(), $classes, true)) {
                return false;
            }

            return true;
        };

        return array_filter($relations, $filter);
    }
}
