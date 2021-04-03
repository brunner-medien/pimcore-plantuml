<?php

namespace PlantUmlBundle\Model;

interface FieldInterface extends ModelInterface
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
     * @return string
     */
    public function getFieldType();

    /**
     * @param string $fieldType
     */
    public function setFieldType(string $fieldType);

    /**
     * @return string
     */
    public function getDataType();

    /**
     * @param string $dataType
     */
    public function setDataType(string $dataType);

    /**
     * @return bool
     */
    public function getLocalized();

    /**
     * @param bool $localized
     */
    public function setLocalized(bool $localized);

    /**
     * @return bool
     */
    public function getHidden();

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden);

    /**
     * @return bool
     */
    public function getRequired();

    /**
     * @param bool $required
     */
    public function setRequired(bool $required);


    /**
     * @return string[]
     */
    public function getUnits();

    /**
     * @param string $unit
     */
    public function addUnit(string $unit);

    /**
     * @return bool
     */
    public function hasUnits();

    /**
     * @param bool $hasUnits
     */
    public function setHasUnits(bool $hasUnits);

    /**
     * @return array
     */
    public function getValues();

    /**
     * @param string $key
     * @param string $value
     */
    public function addValue(string $key, string $value);

    /**
     * @return bool
     */
    public function hasValues();

    /**
     * @param bool $hasValues
     */
    public function setHasValues(bool $hasValues);

    /**
     * @param RelationInterface $relation
     */
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
