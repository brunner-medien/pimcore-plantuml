<?php

declare(strict_types=1);

namespace PlantUmlBundle\Registry;

use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\RelationInterface;

interface RegistryInterface
{
    public function reset();

    /**
     * @return ClassInterface
     */
    public function getClass(array $namespace, string $name);

    /**
     * @return FieldInterface
     */
    public function getField(array $namespace, string $name);

    /**
     * @return RelationInterface
     */
    public function getRelation(array $namespace, string $name);

    /**
     * @return ClassInterface[]
     */
    public function getClasses();

    /**
     * @return RelationInterface[]
     */
    public function getRelations();
}
