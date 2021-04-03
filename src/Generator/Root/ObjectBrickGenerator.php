<?php

namespace PlantUmlBundle\Generator\Root;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\FieldDefinitionTrait;
use Pimcore\Model\DataObject\Objectbrick\Definition;
use PlantUmlBundle\Model\ModelInterface;

/**
 * @property Definition $definition
 */
class ObjectBrickGenerator extends AbstractGenerator implements GeneratorInterface
{

    use FieldDefinitionTrait;

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        $classname = ucfirst($this->definition->getKey());
        $classNamespace = array_merge($namespace, [$classname]);
        $class = $this->generateClass($namespace, $classname, $active);
        $class->setTitle($this->definition->getKey());
        $class->setStereotype(ModelInterface::STEREOTYPE_OBJECTBRICK);

        $this->processFieldDefinitions($class, $this->definition->getFieldDefinitions(), $classNamespace, $class->getIsActive());
    }

}
