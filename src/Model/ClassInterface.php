<?php

namespace PlantUmlBundle\Model;

interface ClassInterface extends ModelInterface
{

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     */
    public function setTitle(string $title);

    /**
     * @return bool
     */
    public function getIsSeedable();

    /**
     * @return bool
     */
    public function getIsActive();

    /**
     * @param bool $active
     */
    public function setIsActive(bool $active);

    /**
     * @return bool
     */
    public function getIsAssociationClass();

    /**
     * @param bool $associationClass
     */
    public function setIsAssociationClass(bool $associationClass);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @param FieldInterface $field
     */
    public function addField(FieldInterface $field);

    /**
     * @return RelationInterface[]
     */
    public function getRelations();

    /**
     * @param RelationInterface $relation
     */
    public function addRelation(RelationInterface $relation);

    /**
     * @return ClassInterface
     */
    public function getGeneralizeClass();

    /**
     * @param ClassInterface|null $class
     */
    public function setGeneralizeClass(ClassInterface $class = null);

    /**
     * @return ClassInterface[]
     */
    public function getRealizeClasses();

    /**
     * @param ClassInterface[]
     */
    public function setRealizeClasses(array $classes);

    /**
     * @param ClassInterface $class
     */
    public function addRealizeClass(ClassInterface $class);

    /**
     * @param ClassInterface $class
     */
    public function removeRealizeClass(ClassInterface $class);

    /**
     * @return string|null
     */
    public function getStereotype();

    /**
     * @param string $stereotype
     */
    public function setStereotype(string $stereotype);

}
