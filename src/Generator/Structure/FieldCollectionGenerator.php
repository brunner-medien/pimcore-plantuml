<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Structure;

use Pimcore\Model\DataObject\ClassDefinition\Data\Fieldcollections;
use Pimcore\Model\DataObject\Fieldcollection;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;

/**
 * @property Fieldcollections $definition
 */
class FieldCollectionGenerator extends AbstractGenerator implements GeneratorInterface
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
            if ($fieldCollection = Fieldcollection\Definition::getByKey($allowedType)) {
                $allowedClasses[] = [
                    'namespace' => [ModelInterface::CLASS_FIELD_COLLECTION],
                    'class' => $allowedType,
                ];
            }
        }

        if (sizeof($allowedClasses) > 0) {
            $relation = $this->generateRelation($namespace);
            $relation->setLocalMinMultiplicity(1);
            $relation->setLocalMaxMultiplicity(1);
            $relation->setForeignMaxMultiplicity($this->definition->getMaxItems() ?: null);
            $relation->setType(RelationInterface::TYPE_COMPOSITION);

            $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);
        }
    }
}
