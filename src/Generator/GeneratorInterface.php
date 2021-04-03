<?php

namespace PlantUmlBundle\Generator;

use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\RelationInterface;
use PlantUmlBundle\Registry\RegistryInterface;

interface GeneratorInterface
{
    /**
     * Setter dependency injection
     *
     * @param object $definition
     */
    public function setDefinition(object $definition);

    /**
     * Setter dependency injection
     *
     * @param RegistryInterface $registry
     */
    public function setRegistry(RegistryInterface $registry);

    /**
     * Setter dependency injection
     *
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @return RelationInterface[]
     */
    public function getRelations();

}
