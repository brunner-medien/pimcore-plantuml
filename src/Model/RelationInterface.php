<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface RelationInterface extends ModelInterface
{
    public const TYPE_ASSOCIATION = 'ASSOCIATION';

    public const TYPE_COMPOSITION = 'COMPOSITION';

    /**
     * @return string
     */
    public function getTitle();

    public function setTitle(string $title);

    /**
     * @return string
     */
    public function getType();

    public function setType(string $type);

    /**
     * @return ClassInterface
     */
    public function getLocalClass();

    public function setLocalClass(ClassInterface $class);

    /**
     * @return ClassInterface
     */
    public function getForeignClass();

    public function setForeignClass(ClassInterface $class);

    /**
     * @return string|null
     */
    public function getForeignName();

    public function setForeignName(string $foreignName = null);

    /**
     * @return string|null
     */
    public function getForeignTitle();

    public function setForeignTitle(string $foreignTitle = null);

    /**
     * @return ClassInterface|null
     */
    public function getRelationClass();

    public function setRelationClass(ClassInterface $class);

    /**
     * @return int
     */
    public function getLocalMinMultiplicity();

    public function setLocalMinMultiplicity(int $multiplicity);

    /**
     * @return int|null
     */
    public function getLocalMaxMultiplicity();

    public function setLocalMaxMultiplicity(int $multiplicity = null);

    /**
     * @return int
     */
    public function getForeignMinMultiplicity();

    public function setForeignMinMultiplicity(int $multiplicity);

    /**
     * @return int|null
     */
    public function getForeignMaxMultiplicity();

    public function setForeignMaxMultiplicity(int $multiplicity = null);

    /**
     * @return bool
     */
    public function getLocalized();

    public function setLocalized(bool $localized);
}
