<?php

declare(strict_types=1);

namespace PlantUmlBundle\Registry;

use PlantUmlBundle\Model\AbstractModel;
use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\FactoryInterface;
use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\RelationInterface;

class Registry implements RegistryInterface
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var ClassInterface[]
     */
    protected $classes = [];

    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @var RelationInterface[]
     */
    protected $relations = [];

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function reset()
    {
        $this->classes = $this->fields = $this->relations = [];
    }

    /**
     * @return ClassInterface
     */
    public function getClass(array $namespace, string $name)
    {
        $id = AbstractModel::generateNamespaceName($namespace, $name);
        if (! array_key_exists($id, $this->classes)) {
            $class = $this->factory->buildClass();
            $class->setNamespace($namespace);
            $class->setName($name);
            $this->classes[$id] = $class;
        }

        return $this->classes[$id];
    }

    /**
     * @return FieldInterface
     */
    public function getField(array $namespace, string $name)
    {
        $id = AbstractModel::generateNamespaceName($namespace, $name);
        if (! array_key_exists($id, $this->fields)) {
            $field = $this->factory->buildField();
            $field->setNamespace($namespace);
            $field->setName($name);
            $this->fields[$id] = $field;
        }

        return $this->fields[$id];
    }

    /**
     * @return RelationInterface
     */
    public function getRelation(array $namespace, string $name)
    {
        $id = AbstractModel::generateNamespaceName($namespace, $name);
        if (! array_key_exists($id, $this->relations)) {
            $relation = $this->factory->buildRelation();
            $relation->setNamespace($namespace);
            $relation->setName($name);
            $this->relations[$id] = $relation;
        }

        return $this->relations[$id];
    }

    /**
     * @return ClassInterface[]
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * @return RelationInterface[]
     */
    public function getRelations()
    {
        return $this->relations;
    }
}
