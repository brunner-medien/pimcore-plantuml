<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator;

use PlantUmlBundle\Registry\RegistryInterface;

class GeneratorFactory implements FactoryInterface
{
    /**
     * @var string[]
     */
    protected $classMap = [
        'Pimcore\\Model\\DataObject\\ClassDefinition' => 'PlantUmlBundle\\Generator\\Root\\ClassGenerator',
        'Pimcore\\Model\\DataObject\\Fieldcollection\\Definition' => 'PlantUmlBundle\\Generator\\Root\\FieldCollectionGenerator',
        'Pimcore\\Model\\DataObject\\Classificationstore\\GroupConfig' => 'PlantUmlBundle\\Generator\\Root\\ClassificationGroupGenerator',
        'Pimcore\\Model\\DataObject\\Objectbrick\\Definition' => 'PlantUmlBundle\\Generator\\Root\\ObjectBrickGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\QuantityValue' => 'PlantUmlBundle\\Generator\\Field\\QuantityValueGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\InputQuantityValue' => 'PlantUmlBundle\\Generator\\Field\\QuantityValueGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Select' => 'PlantUmlBundle\\Generator\\ValueList\\SelectGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Multiselect' => 'PlantUmlBundle\\Generator\\ValueList\\MultiSelectGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Image' => 'PlantUmlBundle\\Generator\\Asset\\ImageGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Hotspotimage' => 'PlantUmlBundle\\Generator\\Asset\\ImageGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ImageGallery' => 'PlantUmlBundle\\Generator\\Asset\\ImageGalleryGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Video' => 'PlantUmlBundle\\Generator\\Asset\\VideoGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToManyObjectRelation' => 'PlantUmlBundle\\Generator\\Relation\\ManyToManyGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToManyRelation' => 'PlantUmlBundle\\Generator\\Relation\\ManyToManyGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToOneRelation' => 'PlantUmlBundle\\Generator\\Relation\\ManyToOneGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\AdvancedManyToManyRelation' => 'PlantUmlBundle\\Generator\\Relation\\AdvancedManyToManyGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\AdvancedManyToManyObjectRelation' => 'PlantUmlBundle\\Generator\\Relation\\AdvancedManyToManyGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ReverseManyToManyObjectRelation' => 'PlantUmlBundle\\Generator\\Relation\\ReverseManyToManyGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Localizedfields' => 'PlantUmlBundle\\Generator\\Structure\\LocalizedGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Block' => 'PlantUmlBundle\\Generator\\Structure\\BlockGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Fieldcollections' => 'PlantUmlBundle\\Generator\\Structure\\FieldCollectionGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Classificationstore' => 'PlantUmlBundle\\Generator\\Structure\\ClassificationStoreGenerator',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Objectbricks' => 'PlantUmlBundle\\Generator\\Structure\\ObjectBrickGenerator',
    ];

    /**
     * @var RegistryInterface
     */
    protected $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return GeneratorInterface|null
     */
    public function buildGenerator(object $definition)
    {
        $generator = null;
        $classname = get_class($definition);

        $generatorName = $this->getDefaultGeneratorName();
        if (array_key_exists($classname, $this->classMap)) {
            $generatorName = $this->classMap[$classname];
        }

        /** @var GeneratorInterface $generator */
        $generator = new $generatorName();

        // setter dependency injection
        $generator->setDefinition($definition);
        $generator->setRegistry($this->registry);
        $generator->setFactory($this);

        return $generator;
    }

    /**
     * @return string
     */
    protected function getDefaultGeneratorName()
    {
        return 'PlantUmlBundle\\Generator\\Field\\DefaultGenerator';
    }
}
