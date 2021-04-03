<?php

namespace PlantUmlBundle\Generator\ValueList;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;

/**
 * @property Data $definition
 */
abstract class AbstractListGenerator extends AbstractGenerator implements GeneratorInterface
{

}