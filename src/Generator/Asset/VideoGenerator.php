<?php

namespace PlantUmlBundle\Generator\Asset;

use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\ModelInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\Video;

/**
 * @property Video $definition
 */
class VideoGenerator extends AbstractAssetGenerator implements GeneratorInterface
{

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        $class = $this->generateClass([ModelInterface::CLASS_ASSET], ModelInterface::CLASS_ASSET_VIDEO, $active);

        $relation = $this->generateRelation($namespace);
        $relation->setForeignMaxMultiplicity(1);
        $relation->setForeignClass($class);

        $this->generateRelationField($namespace, $relation);
    }

}