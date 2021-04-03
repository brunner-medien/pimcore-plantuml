<?php

namespace PlantUmlBundle\Generator\Relation;

use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\ModelInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data\ReverseManyToManyObjectRelation;

/**
 * @property ReverseManyToManyObjectRelation $definition
 */
class ReverseManyToManyGenerator extends AbstractRelationGenerator implements GeneratorInterface
{

    /**
     * @param string[] $namespace
     * @param bool $active
     */
    public function generate(array $namespace, bool $active = false)
    {
        if (
            ($ownerClass = $this->definition->getOwnerClassName())
                &&
            ($ownerField = $this->definition->getOwnerFieldName())
        ) {
            $this->generateClass([ModelInterface::CLASS_OBJECT], $ownerClass, $active);
            $ownerClassNamespace = [ModelInterface::CLASS_OBJECT, $ownerClass];

            $relation = $this->registry->getRelation($ownerClassNamespace, $ownerField);
            $relation->setForeignName($this->definition->getName());
            $relation->setForeignTitle($this->definition->getTitle());

            $this->generateRelationField($namespace, $relation);
        }
    }

}

