<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Structure;

use Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;

/**
 * @property Localizedfields $definition
 */
class LocalizedGenerator extends AbstractGenerator implements GeneratorInterface
{
    /**
     * @param string[] $namespace
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
