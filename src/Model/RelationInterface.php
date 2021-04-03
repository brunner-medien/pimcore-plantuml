<?php

namespace PlantUmlBundle\Model;

interface RelationInterface extends ModelInterface
{

    const TYPE_ASSOCIATION = 'ASSOCIATION';

    const TYPE_COMPOSIION = 'COMPOSITION';

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
    public function getType();

    /**
     * @param string $type
     */
    public function setType(string $type);

    /**
     * @return ClassInterface
     */
    public function getLocalClass();

    /**
     * @param ClassInterface $class
     */
    public function setLocalClass(ClassInterface $class);

    /**
     * @return ClassInterface
     */
    public function getForeignClass();

    /**
     * @param ClassInterface $class
     */
    public function setForeignClass(ClassInterface $class);

    /**
     * @return string|null
     */
    public function getForeignName();

    /**
     * @param string|null $foreignName
     */
    public function setForeignName(string $foreignName = null);

    /**
     * @param string|null $foreignTitle
     */
    public function setForeignTitle(string $foreignTitle = null);

    /**
     * @return ClassInterface|null
     */
    public function getRelationClass();

    /**
     * @param ClassInterface $class
     */
    public function setRelationClass(ClassInterface $class);

    /**
     * @return int
     */
    public function getLocalMinMultiplicity();

    /**
     * @param int $multiplicity
     */
    public function setLocalMinMultiplicity(int $multiplicity);

    /**
     * @return int|null
     */
    public function getLocalMaxMultiplicity();

    /**
     * @param int|null $multiplicity
     */
    public function setLocalMaxMultiplicity(int $multiplicity = null);

    /**
     * @return int
     */
    public function getForeignMinMultiplicity();

    /**
     * @param int $multiplicity
     */
    public function setForeignMinMultiplicity(int $multiplicity);

    /**
     * @return int|null
     */
    public function getForeignMaxMultiplicity();

    /**
     * @param int|null $multiplicity
     */
    public function setForeignMaxMultiplicity(int $multiplicity = null);

    /**
     * @return bool
     */
    public function getLocalized();

    /**
     * @param bool $localized
     */
    public function setLocalized(bool $localized);

}
