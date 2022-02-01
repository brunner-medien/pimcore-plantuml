<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Asset;

use Pimcore\Model\DataObject\ClassDefinition\Data\Image;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\ModelInterface;

/**
 * @property Image $definition
 */
class ImageGalleryGenerator extends AbstractAssetGenerator implements GeneratorInterface
{
    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $class = $this->generateClass([ModelInterface::CLASS_ASSET], ModelInterface::CLASS_ASSET_IMAGE, $active);

        $relation = $this->generateRelation($namespace);
        $relation->setForeignMinMultiplicity($this->definition->getMandatory() ? 1 : 0);
        $relation->setForeignMaxMultiplicity(null);
        $relation->setForeignClass($class);

        $this->generateRelationField($namespace, $relation);
    }
}
