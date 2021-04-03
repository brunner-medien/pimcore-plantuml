<?php

namespace PlantUmlBundle\Generator\Root;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\FieldDefinitionTrait;
use Pimcore\Model\DataObject\ClassDefinition;

/**
 * @property ClassDefinition $definition
 */
class ClassGenerator extends AbstractGenerator implements GeneratorInterface
{

    use FieldDefinitionTrait;

    /**
     * @param string[] $namespace
     * @param bool $active
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
