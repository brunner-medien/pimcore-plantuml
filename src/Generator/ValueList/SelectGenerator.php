<?php

namespace PlantUmlBundle\Generator\ValueList;

use PlantUmlBundle\Generator\GeneratorInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\Select;

/**
 * @property Select $definition
 */
class SelectGenerator extends AbstractListGenerator implements GeneratorInterface
{

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        $field = $this->generateField($namespace);
        $field->setHasValues(true);

        foreach ($this->definition->getOptions() as $option) {
            $field->addValue($option['key'], $option['value']);
        }
    }

}