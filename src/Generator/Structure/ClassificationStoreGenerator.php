<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Structure;

use Pimcore\Model\DataObject\ClassDefinition\Data\Classificationstore;
use Pimcore\Model\DataObject\Classificationstore\GroupConfig;
use Pimcore\Model\DataObject\Classificationstore\StoreConfig;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\AssociationClassTrait;
use PlantUmlBundle\Model\AbstractModel;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;

/**
 * @property Classificationstore $definition
 */
class ClassificationStoreGenerator extends AbstractGenerator implements GeneratorInterface
{
    use AssociationClassTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $storeId = $this->definition->getStoreId();
        if (! $storeConfig = StoreConfig::getById($storeId)) {
            return;
        }

        $allowedClasses = [];
        $listing = new GroupConfig\Listing();
        $listing->setCondition('storeId = ?', $storeId);
        foreach ($listing->load() as $groupConfig) {
            $groupId = $groupConfig->getId();
            if (
                empty($this->definition->getAllowedGroupIds())
                    ||
                in_array($groupId, $this->definition->getAllowedGroupIds(), true)
            ) {
                $allowedClasses[] = [
                    'namespace' => [ModelInterface::CLASS_CLASSIFICATION],
                    'class' => AbstractModel::generateClassificationGroupName($groupId),
                ];
            }
        }

        if (sizeof($allowedClasses) > 0) {
            $relation = $this->generateRelation($namespace);
            $relation->setLocalMinMultiplicity(1);
            $relation->setLocalMaxMultiplicity(1);

            $relation->setForeignMaxMultiplicity(sizeof($allowedClasses) === 1 ? 1 : null);
            $relation->setType(RelationInterface::TYPE_COMPOSITION);
            $relation->setLocalized($this->definition->isLocalized());

            $this->processAllowedClasses($namespace, $relation, $allowedClasses, $active);
        }
    }
}
