<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Relation;

use Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;

/**
 * @property ManyToOneRelation $definition
 */
class ManyToOneGenerator extends AbstractRelationGenerator implements GeneratorInterface
{
    use AssociationClassTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $relation = $this->generateRelation($namespace);
        $relation->setForeignMinMultiplicity($this->definition->getMandatory() ? 1 : 0);
        $relation->setForeignMaxMultiplicity(1);

        $allowedClasses = $this->getAllowedClasses();
        $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);

        $this->generateRelationField($namespace, $relation);
    }
}
