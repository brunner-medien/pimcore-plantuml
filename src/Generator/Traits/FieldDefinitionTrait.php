<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Traits;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\ClassInterface;

trait FieldDefinitionTrait
{
    /**
     * @param Data[] $fieldDefinitions
     * @param string[] $namespace
     */
    protected function processFieldDefinitions(ClassInterface $class, array $fieldDefinitions, array $namespace, bool $active = false)
    {
        foreach ($fieldDefinitions as $fieldDefinition) {
            if ($generator = $this->factory->buildGenerator($fieldDefinition)) {

                /** @var GeneratorInterface $generator */
                $generator->generate($namespace, $active);

                foreach ($generator->getFields() as $field) {
                    $class->addField($field);
                    $this->fields[] = $field;
                }

                foreach ($generator->getRelations() as $relation) {
                    $class->addRelation($relation);
                    $relation->setLocalClass($class);
                    $this->relations[] = $relation;
                }
            }
        }
    }
}
