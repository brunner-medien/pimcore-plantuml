<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Structure;

use Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;

/**
 * @property Objectbricks $definition
 */
class ObjectBrickGenerator extends AbstractGenerator implements GeneratorInterface
{
    use AssociationClassTrait;

    /**
     * @param string[] $namespace
     * @throws \Exception
     */
    public function generate(array $namespace, bool $active = false)
    {
        $allowedClasses = [];
        foreach ($this->definition->getAllowedTypes() as $allowedType) {
            $allowedClasses[] = [
                'namespace' => [ModelInterface::CLASS_OBJECT_BRICK],
                'class' => ucfirst($allowedType),
            ];
        }

        if (sizeof($allowedClasses) > 0) {
            $relation = $this->generateRelation($namespace);
            $relation->setLocalMinMultiplicity(1);
            $relation->setLocalMaxMultiplicity(1);

            // maxItems counts for the total amount of different object bricks -
            // if we have a single allowed item it is 1:
            $maxItems = sizeof($allowedClasses) === 1 ? 1 : ($this->definition->getMaxItems() ?: null);
            $relation->setForeignMaxMultiplicity($maxItems);
            $relation->setType(RelationInterface::TYPE_COMPOSITION);

            $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);
        }
    }
}
