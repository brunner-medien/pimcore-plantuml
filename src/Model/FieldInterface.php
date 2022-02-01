<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface FieldInterface extends ModelInterface
{
    /**
     * @return string
     */
    public function getTitle();

    public function setTitle(string $title);

    /**
     * @return string
     */
    public function getFieldType();

    public function setFieldType(string $fieldType);

    /**
     * @return string
     */
    public function getDataType();

    public function setDataType(string $dataType);

    /**
     * @return bool
     */
    public function getLocalized();

    public function setLocalized(bool $localized);

    /**
     * @return bool
     */
    public function getHidden();

    public function setHidden(bool $hidden);

    /**
     * @return bool
     */
    public function getRequired();

    public function setRequired(bool $required);

    /**
     * @return string[]
     */
    public function getUnits();

    public function addUnit(string $unit);

    /**
     * @return bool
     */
    public function hasUnits();

    public function setHasUnits(bool $hasUnits);

    /**
     * @return array
     */
    public function getValues();

    public function addValue(string $key, string $value);

    /**
     * @return bool
     */
    public function hasValues();

    public function setHasValues(bool $hasValues);

    public function setRelation(RelationInterface $relation);

    /**
     * @return bool
     */
    public function getIsRelation();

    /**
     * @return RelationInterface|null
     */
    public function getRelation();
}
