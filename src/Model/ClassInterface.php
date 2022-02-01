<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface ClassInterface extends ModelInterface
{
    /**
     * @return string
     */
    public function getTitle();

    public function setTitle(string $title);

    /**
     * @return bool
     */
    public function getIsSeedable();

    /**
     * @return bool
     */
    public function getIsActive();

    public function setIsActive(bool $active);

    /**
     * @return bool
     */
    public function getIsAssociationClass();

    public function setIsAssociationClass(bool $associationClass);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    public function addField(FieldInterface $field);

    /**
     * @return RelationInterface[]
     */
    public function getRelations();

    public function addRelation(RelationInterface $relation);

    /**
     * @return ClassInterface
     */
    public function getGeneralizeClass();

    public function setGeneralizeClass(ClassInterface $class = null);

    /**
     * @return ClassInterface[]
     */
    public function getRealizeClasses();

    /**
     * @param ClassInterface[] $classes
     */
    public function setRealizeClasses(array $classes);

    public function addRealizeClass(ClassInterface $class);

    public function removeRealizeClass(ClassInterface $class);

    /**
     * @return string|null
     */
    public function getStereotype();

    public function setStereotype(string $stereotype);
}
