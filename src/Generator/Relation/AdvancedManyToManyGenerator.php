<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Relation;

use Pimcore\Model\DataObject\ClassDefinition\Data\AdvancedManyToManyRelation;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;
use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\ModelInterface;

/**
 * @property AdvancedManyToManyRelation $definition
 */
class AdvancedManyToManyGenerator extends AbstractRelationGenerator implements GeneratorInterface
{
    use AssociationClassTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $relation = $this->generateRelation($namespace);
        $relation->setForeignMinMultiplicity($this->definition->getMandatory() ? 1 : 0);
        $relation->setForeignMaxMultiplicity($this->definition->getMaxItems() ?: null);

        $allowedClasses = $this->getAllowedClasses();
        $foreignClass = $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);

        if ($foreignClass) {
            $relationClass = $this->generateRelationClass($namespace, $active);
            $relation->setRelationClass($relationClass);
        }

        $this->generateRelationField($namespace, $relation);
    }

    /**
     * @return ClassInterface
     */
    protected function generateRelationClass(array $namespace, bool $active)
    {
        $relationClassName = ucfirst($this->definition->getName());
        $relationClass = $this->generateClass($namespace, $relationClassName, $active);
        $relationClass->setTitle($this->definition->getName());
        $relationClass->setStereotype(ModelInterface::STEREOTYPE_RELATION);

        $relationClassNamespace = array_merge($namespace, [$relationClassName]);

        foreach ($this->definition->getColumns() as $column) {
            $field = $this->registry->getField($relationClassNamespace, $column['key']);
            $field->setTitle($column['label'] ?? $column['key']);
            $field->setFieldType($column['type']);
            $relationClass->addField($field);
        }

        return $relationClass;
    }
}
