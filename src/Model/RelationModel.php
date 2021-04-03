<?php

namespace PlantUmlBundle\Model;

class RelationModel extends AbstractModel implements RelationInterface
{

    /**
     * @var string
     */
    protected $type = RelationInterface::TYPE_ASSOCIATION;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var ClassInterface
     */
    protected $localClass;

    /**
     * @var ClassInterface
     */
    protected $foreignClass;

    /**
     * @var ClassInterface|null
     */
    protected $relationClass;

    /**
     * @var string|null
     */
    protected $foreignName;

    /**
     * @var string|null
     */
    protected $foreignTitle;

    /**
     * @var integer
     */
    protected $localMinMultiplicity = 0;

    /**
     * @var integer|null
     */
    protected $localMaxMultiplicity = null;

    /**
     * @var integer
     */
    protected $foreignMinMultiplicity = 0;

    /**
     * @var integer|null
     */
    protected $foreignMaxMultiplicity = null;

    /**
     * @var bool
     */
    protected $localized = false;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return ClassInterface
     */
    public function getLocalClass()
    {
        return $this->localClass;
    }

    /**
     * @param ClassInterface $class
     */
    public function setLocalClass(ClassInterface $class)
    {
        $this->localClass = $class;
    }

    /**
     * @return ClassInterface
     */
    public function getForeignClass()
    {
        return $this->foreignClass;
    }

    /**
     * @param ClassInterface $class
     */
    public function setForeignClass(ClassInterface $class)
    {
        $this->foreignClass = $class;
    }

    /**
     * @return string|null
     */
    public function getForeignName()
    {
        return $this->foreignName;
    }

    /**
     * @param string|null $foreignName
     */
    public function setForeignName(string $foreignName = null)
    {
        $this->foreignName = $foreignName;
    }

    /**
     * @param string|null $foreignTitle
     */
    public function setForeignTitle(string $foreignTitle = null)
    {
        $this->foreignTitle = $foreignTitle;
    }

    /**
     * @return ClassInterface|null
     */
    public function getRelationClass()
    {
        return $this->relationClass;
    }

    /**
     * @param ClassInterface $class
     */
    public function setRelationClass(ClassInterface $class)
    {
        $this->relationClass = $class;
    }

    /**
     * @return int
     */
    public function getLocalMinMultiplicity()
    {
        return $this->localMinMultiplicity;
    }

    /**
     * @param int $multiplicity
     */
    public function setLocalMinMultiplicity(int $multiplicity)
    {
        $this->localMinMultiplicity = $multiplicity;
    }

    /**
     * @return int|null
     */
    public function getLocalMaxMultiplicity()
    {
        return $this->localMaxMultiplicity;
    }

    /**
     * @param int|null $multiplicity
     */
    public function setLocalMaxMultiplicity(int $multiplicity = null)
    {
        $this->localMaxMultiplicity = $multiplicity;
    }

    /**
     * @return int
     */
    public function getForeignMinMultiplicity()
    {
        return $this->foreignMinMultiplicity;
    }

    /**
     * @param int $multiplicity
     */
    public function setForeignMinMultiplicity(int $multiplicity)
    {
        $this->foreignMinMultiplicity = $multiplicity;
    }

    /**
     * @return int|null
     */
    public function getForeignMaxMultiplicity()
    {
        return $this->foreignMaxMultiplicity;
    }

    /**
     * @param int|null $multiplicity
     */
    public function setForeignMaxMultiplicity(int $multiplicity = null)
    {
        $this->foreignMaxMultiplicity = $multiplicity;
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

}
