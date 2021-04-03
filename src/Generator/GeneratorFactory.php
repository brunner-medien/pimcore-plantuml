<?php

namespace PlantUmlBundle\Generator;

use PlantUmlBundle\Registry\RegistryInterface;

class GeneratorFactory implements FactoryInterface
{

    /**
     * @var string[]
     */
    protected $classMap = [
        'Pimcore\\Model\\DataObject\\ClassDefinition' => 'Root\\Class',
        'Pimcore\\Model\\DataObject\\Fieldcollection\\Definition' => 'Root\\FieldCollection',
        'Pimcore\\Model\\DataObject\\Classificationstore\\GroupConfig' => 'Root\\ClassificationGroup',
        'Pimcore\\Model\\DataObject\\Objectbrick\\Definition' => 'Root\\ObjectBrick',

        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\QuantityValue' => 'Field\\QuantityValue',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\InputQuantityValue' => 'Field\\QuantityValue',

        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Select' => 'ValueList\\Select',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Multiselect' => 'ValueList\\MultiSelect',

        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Image' => 'Asset\\Image',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Hotspotimage' => 'Asset\\Image',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ImageGallery' => 'Asset\\ImageGallery',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Video' => 'Asset\\Video',

        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToManyObjectRelation' => 'Relation\\ManyToMany',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToManyRelation' => 'Relation\\ManyToMany',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ManyToOneRelation' => 'Relation\\ManyToOne',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\AdvancedManyToManyRelation' => 'Relation\\AdvancedManyToMany',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\AdvancedManyToManyObjectRelation' => 'Relation\\AdvancedManyToMany',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\ReverseManyToManyObjectRelation' => 'Relation\\ReverseManyToMany',

        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Localizedfields' => 'Structure\\Localized',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Block' => 'Structure\\Block',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Fieldcollections' => 'Structure\\FieldCollection',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Classificationstore' => 'Structure\\ClassificationStore',
        'Pimcore\\Model\\DataObject\\ClassDefinition\\Data\\Objectbricks' => 'Structure\\ObjectBrick',
    ];

    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param object $definition
     * @return GeneratorInterface|null
     */
    public function buildGenerator(object $definition)
    {
        $generator = null;
        $classname = get_class($definition);

        $generatorName = 'Field\\Default';
        if (array_key_exists($classname, $this->classMap)) {
            $generatorName = $this->classMap[$classname];
        }

        $generatorClass = 'PlantUmlBundle\\Generator\\' . $generatorName . 'Generator';
        /* @var GeneratorInterface $generator */
        $generator = new $generatorClass();

        // setter dependency injection
        $generator->setDefinition($definition);
        $generator->setRegistry($this->registry);
        $generator->setFactory($this);

        return $generator;
    }

}
