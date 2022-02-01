<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Relation;

use Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;

/**
 * @property ManyToManyObjectRelation $definition
 */
class ManyToManyGenerator extends AbstractRelationGenerator implements GeneratorInterface
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
        $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);

        $this->generateRelationField($namespace, $relation);
    }
}
