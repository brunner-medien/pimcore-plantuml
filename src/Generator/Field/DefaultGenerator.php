<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Field;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use PlantUmlBundle\Generator\GeneratorInterface;

/**
 * @property Data $definition
 */
class DefaultGenerator extends AbstractFieldGenerator implements GeneratorInterface
{
    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $field = $this->generateField($namespace);
        $field->setDataType($this->guessDataType());
        $field->setHidden($this->check('invisible') === true);
        $field->setRequired($this->check('mandatory') === true);
    }

    /**
     * @return string
     */
    protected function guessDataType()
    {
        $fieldType = $this->definition->getFieldtype();

        if (in_array($fieldType, [
            'numeric',
            'quantityValue',
            'slider',
        ], true)) {
            $signed = $this->check('unsigned') ? 'unsigned ' : '';

            if (true === $this->check('integer')) {
                return $signed . 'integer';
            }
            if ($decimalSize = $this->check('decimalSize')) {
                // square brackets - otherwise would be interpreted as method:
                return $signed . 'decimal[' . $decimalSize . ',' . ($this->check('decimalPrecision') ?: '0') . ']';
            }
            return $signed . 'float';
        }

        if (in_array($fieldType, [
            'input',
            'textarea',
            'inputQuantityValue',
            'wysiwyg',
            'password',
        ], true)) {
            if ($length = $this->check('columnLength')) {
                // square brackets - otherwise would be interpreted as method:
                return 'varchar[' . $length . ']';
            }
            return 'text';
        }

        return $fieldType;
    }

    /**
     * @return mixed
     */
    protected function check(string $property)
    {
        $getter = 'get' . ucfirst($property);
        if (! method_exists($this->definition, $getter)) {
            return null;
        }

        return $this->definition->$getter();
    }
}
