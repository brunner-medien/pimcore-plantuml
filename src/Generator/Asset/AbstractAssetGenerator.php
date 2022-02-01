<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Asset;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;

/**
 * @property Data $definition
 */
abstract class AbstractAssetGenerator extends AbstractGenerator implements GeneratorInterface
{
}
