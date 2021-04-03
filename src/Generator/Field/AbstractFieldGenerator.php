<?php

namespace PlantUmlBundle\Generator\Field;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;

/**
 * @property Data $definition
 */
abstract class AbstractFieldGenerator extends AbstractGenerator implements GeneratorInterface
{

}