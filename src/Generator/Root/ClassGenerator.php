<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Root;

use Pimcore\Model\DataObject\ClassDefinition;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\FieldDefinitionTrait;

/**
 * @property ClassDefinition $definition
 */
class ClassGenerator extends AbstractGenerator implements GeneratorInterface
{
    use FieldDefinitionTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $classname = $this->definition->getName();
        $classNamespace = array_merge($namespace, [$classname]);
        $class = $this->generateClass($namespace, $classname, $active);
        $class->setTitle($classname);

        $this->processFieldDefinitions($class, $this->definition->getFieldDefinitions(), $classNamespace, $class->getIsActive());
    }
}
