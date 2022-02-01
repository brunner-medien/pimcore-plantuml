<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Root;

use Pimcore\Model\DataObject\Fieldcollection\Definition;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\FieldDefinitionTrait;
use PlantUmlBundle\Model\ModelInterface;

/**
 * @property Definition $definition
 */
class FieldCollectionGenerator extends AbstractGenerator implements GeneratorInterface
{
    use FieldDefinitionTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $classname = $this->definition->getKey();
        $classNamespace = array_merge($namespace, [$classname]);
        $class = $this->generateClass($namespace, $classname, $active);
        $class->setTitle($classname);
        $class->setStereotype(ModelInterface::STEREOTYPE_FIELDCOLLECTION);

        $this->processFieldDefinitions($class, $this->definition->getFieldDefinitions(), $classNamespace, $class->getIsActive());
    }
}
