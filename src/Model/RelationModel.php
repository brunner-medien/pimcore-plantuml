<?php

declare(strict_types=1);

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

    public function setForeignName(string $foreignName = null)
    {
        $this->foreignName = $foreignName;
    }

    /**
     * @return string|null
     */
    public function getForeignTitle()
    {
        return $this->foreignTitle;
    }

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

    public function setLocalized(bool $localized)
    {
        $this->localized = $localized;
    }

}
