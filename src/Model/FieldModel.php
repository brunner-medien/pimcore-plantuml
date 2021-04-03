<?php

namespace PlantUmlBundle\Model;

class FieldModel extends AbstractModel implements FieldInterface
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $fieldType;

    /**
     * @var string
     */
    protected $dataType;

    /**
     * @var bool
     */
    protected $localized = false;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var string[]
     */
    protected $units = [];

    /**
     * @var bool
     */
    protected $hasUnits = false;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var bool
     */
    protected $hasValues = false;

    /**
     * @var RelationInterface|null
     */
    protected $relation = null;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * @param string $fieldType
     */
    public function setFieldType(string $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType(string $dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return bool
     */
    public function getLocalized()
    {
        return $this->localized;
    }

    /**
     * @param bool $localized
     */
    public function setLocalized(bool $localized)
    {
        $this->localized = $localized;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required)
    {
        $this->required = $required;
    }

    /**
     * @return string[]
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param string $unit
     */
    public function addUnit(string $unit)
    {
        $this->units[$unit] = $unit;
    }

    /**
     * @return bool
     */
    public function hasUnits()
    {
        return $this->hasUnits;
    }

    /**
     * @param bool $hasUnits
     */
    public function setHasUnits(bool $hasUnits)
    {
        $this->hasUnits = $hasUnits;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addValue(string $key, string $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * @return bool
     */
    public function hasValues()
    {
        return $this->hasValues;
    }

    /**
     * @param bool $hasValues
     */
    public function setHasValues(bool $hasValues)
    {
        $this->hasValues = $hasValues;
    }

    /**
     * @param RelationInterface $relation
     */
    public function setRelation(RelationInterface $relation)
    {
        $this->relation = $relation;
    }

    /**
     * @return bool
     */
    public function getIsRelation()
    {
        return $this->relation instanceof RelationInterface;
    }

    /**
     * @return RelationInterface|null
     */
    public function getRelation()
    {
        return $this->relation;
    }

}
