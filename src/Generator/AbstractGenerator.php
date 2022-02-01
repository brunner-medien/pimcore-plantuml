<?php

namespace PlantUmlBundle\Generator;

use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\ClassModel;
use PlantUmlBundle\Model\FieldInterface;
use PlantUmlBundle\Model\FieldModel;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;
use PlantUmlBundle\Model\RelationModel;
use PlantUmlBundle\Registry\RegistryInterface;

abstract class AbstractGenerator implements GeneratorInterface
{

    /**
     * @var object
     */
    protected $definition;

    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @var RelationInterface[]
     */
    protected $relations = [];

    /**
     * @param object $definition
     */
    public function setDefinition(object $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @param RegistryInterface $registry
     */
    public function setRegistry(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Setter dependency injection
     *
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string[] $namespace
     * @return FieldInterface
     */
    protected function generateField(array $namespace)
    {
        $field = $this->registry->getField($namespace, $this->definition->getName());
        $field->setTitle($this->definition->getTitle());
        $field->setFieldType($this->definition->getFieldType());

        $this->fields[] = $field;

        return $field;
    }

    /**
     * @param string[] $namespace
     * @return RelationInterface
     */
    protected function generateRelation(array $namespace)
    {
        $relation = $this->registry->getRelation($namespace, $this->definition->getName());
        $relation->setTitle($this->definition->getTitle());

        $this->relations[] = $relation;

        return $relation;
    }

    /**
     * @param string[] $namespace
     * @param RelationInterface $relation
     * @return FieldInterface
     */
    protected function generateRelationField(array $namespace, RelationInterface $relation)
    {
        $field = $this->registry->getField($namespace, $this->definition->getName());
        $field->setTitle($this->definition->getTitle());
        $field->setRelation($relation);

        $this->fields[] = $field;

        return $field;
    }

    /**
     * @param string[] $namespace
     * @param string $classname
     * @param bool $active
     *
     * @return ClassInterface
     */
    protected function generateClass(array $namespace, string $classname, bool $active)
    {
        $class = $this->registry->getClass($namespace, $classname);
        $active = $active || $class->getIsActive();
        $class->setIsActive($active);

        // generate base classes for asset and document types
        if (count($namespace) === 1) {
            if ($namespace[0] === ModelInterface::CLASS_ASSET) {

                $parentClass = $this->generateClass([],ModelInterface::CLASS_ASSET, $active);
                $parentClass->setTitle(ModelInterface::CLASS_ASSET);
                $parentClass->setStereotype(ModelInterface::STEREOTYPE_ASSET);

                $class->setGeneralizeClass($parentClass);

            } elseif ($namespace[0] === ModelInterface::CLASS_DOCUMENT) {

                $parentClass = $this->generateClass([],ModelInterface::CLASS_DOCUMENT, $active);
                $parentClass->setTitle(ModelInterface::CLASS_DOCUMENT);
                $parentClass->setStereotype(ModelInterface::STEREOTYPE_DOCUMENT);

                $class->setGeneralizeClass($parentClass);

            }
        }

        // set title and stereotype
        $rootName = (count($namespace) === 0) ? $classname : $namespace[0];
        if ($rootName === ModelInterface::CLASS_ASSET) {

            $class->setTitle($classname);
            $class->setStereotype(ModelInterface::STEREOTYPE_ASSET);

        } elseif ($rootName === ModelInterface::CLASS_DOCUMENT) {

            $class->setTitle($classname);
            $class->setStereotype(ModelInterface::STEREOTYPE_DOCUMENT);

        } elseif ($rootName === ModelInterface::CLASS_OBJECT) {

            // special treating for object folders
            if ($classname === 'folder') {
                $class->setTitle(ucfirst($classname));
                $class->setStereotype(ModelInterface::STEREOTYPE_OBJECT);
            }

        }

        return $class;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return RelationInterface[]
     */
    public function getRelations()
    {
        return $this->relations;
    }

}
