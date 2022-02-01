<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator;

use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\RelationInterface;
use PlantUmlBundle\Registry\RegistryInterface;

interface GeneratorInterface
{
    /**
     * Setter dependency injection
     */
    public function setDefinition(object $definition);

    /**
     * Setter dependency injection
     */
    public function setRegistry(RegistryInterface $registry);

    /**
     * Setter dependency injection
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * @param string[] $namespace
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
