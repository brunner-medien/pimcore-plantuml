<?php

namespace PlantUmlBundle\Generator\Asset;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;

/**
 * @property Data $definition
 */
abstract class AbstractAssetGenerator extends AbstractGenerator implements GeneratorInterface
{

}