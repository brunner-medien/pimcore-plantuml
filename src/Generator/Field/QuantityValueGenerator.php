<?php

namespace PlantUmlBundle\Generator\Field;

use Pimcore\Model\DataObject\ClassDefinition\Data\QuantityValue;
use Pimcore\Model\DataObject\QuantityValue\Unit;

/**
 * @property QuantityValue $definition
 */
class QuantityValueGenerator extends DefaultGenerator
{

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        $field = $this->generateField($namespace);
        $field->setDataType($this->guessDataType());

        $field->setHasUnits(true);
        foreach ($this->definition->getValidUnits() as $unitId) {
            if ($unit = Unit::getById($unitId)) {
                $field->addUnit($unit->getAbbreviation());
            }
        }
    }

}