<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\ValueList;

use Pimcore\Model\DataObject\ClassDefinition\Data\Select;
use PlantUmlBundle\Generator\GeneratorInterface;

/**
 * @property Select $definition
 */
class SelectGenerator extends AbstractListGenerator implements GeneratorInterface
{
    /**
     * @param string[] $namespace
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
