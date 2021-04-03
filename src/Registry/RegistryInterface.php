<?php

namespace PlantUmlBundle\Registry;

use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\RelationInterface;

interface RegistryInterface
{

    /**
     * @return void
     */
    public function reset();

    /**
     * @param array $namespace
     * @param string $name
     *
     * @return ClassInterface
     */
    public function getClass(array $namespace, string $name);

    /**
     * @param array $namespace
     * @param string $name
     *
     * @return FieldInterface
     */
    public function getField(array $namespace, string $name);

    /**
     * @param array $namespace
     * @param string $name
     *
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
