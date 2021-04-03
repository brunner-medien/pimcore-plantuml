<?php

namespace PlantUmlBundle\Generator\Structure;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields;

/**
 * @property Localizedfields $definition
 */
class LocalizedGenerator extends AbstractGenerator implements GeneratorInterface
{

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        foreach ($this->definition->getFieldDefinitions() as $definition) {
            if ($generator = $this->factory->buildGenerator($definition)) {
                $generator->generate($namespace, $active);
                foreach ($generator->getFields() as $field) {
                    $field->setLocalized(true);
                    $this->fields[] = $field;
                }
            }
        }
    }

}