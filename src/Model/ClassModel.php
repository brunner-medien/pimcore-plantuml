<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

class ClassModel extends AbstractModel implements ClassInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var bool
     */
    protected $associationClass = false;

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @var RelationInterface[]
     */
    protected $relations = [];

    /**
     * @var ClassInterface
     */
    protected $generalizeClass;

    /**
     * @var ClassInterface[]
     */
    protected $realizeClasses = [];

    /**
     * @var string|null
     */
    protected $stereotype;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function getIsSeedable()
    {
        return count($this->namespace) === 1 && $this->namespace[0] === ModelInterface::CLASS_OBJECT;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->active;
    }

    public function setIsActive(bool $active)
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function getIsAssociationClass()
    {
        return $this->associationClass;
    }

    public function setIsAssociationClass(bool $associationClass)
    {
        $this->associationClass = $associationClass;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function addField(FieldInterface $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @return RelationInterface[]
     */
    public function getRelations()
    {
        return $this->relations;
    }

    public function addRelation(RelationInterface $relation)
    {
        $this->relations[] = $relation;
    }

    /**
     * @return ClassInterface
     */
    public function getGeneralizeClass()
    {
        return $this->generalizeClass;
    }

    public function setGeneralizeClass(ClassInterface $class = null)
    {
        $this->generalizeClass = $class;
    }

    /**
     * @return ClassInterface[]
     */
    public function getRealizeClasses()
    {
        return $this->realizeClasses;
    }

    /**
     * @param ClassInterface[] $classes
     */
    public function setRealizeClasses(array $classes)
    {
        $this->realizeClasses = $classes;
    }

    public function addRealizeClass(ClassInterface $class)
    {
        $this->realizeClasses[$class->getNamespaceName()] = $class;
    }

    public function removeRealizeClass(ClassInterface $class)
    {
        unset($this->realizeClasses[$class->getNamespaceName()]);
    }

    /**
     * @return string|null
     */
    public function getStereotype()
    {
        return $this->stereotype;
    }

    public function setStereotype(string $stereotype)
    {
        $this->stereotype = $stereotype;
    }
}
