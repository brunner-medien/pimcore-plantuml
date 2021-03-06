<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Structure;

use Pimcore\Model\DataObject\ClassDefinition\Data\Block;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Generator\Traits\FieldDefinitionTrait;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;

/**
 * @property Block $definition
 */
class BlockGenerator extends AbstractGenerator implements GeneratorInterface
{
    use FieldDefinitionTrait;

    /**
     * @param string[] $namespace
     */
    public function generate(array $namespace, bool $active = false)
    {
        $classname = ucfirst($this->definition->getName());
        $classNamespace = array_merge($namespace, [$classname]);
        $class = $this->generateClass($namespace, $classname, $active);
        $class->setTitle($this->definition->getName());
        $class->setStereotype(ModelInterface::STEREOTYPE_BLOCK);

        $this->processFieldDefinitions($class, $this->definition->getFieldDefinitions(), $classNamespace, $active);

        // we must NOT return generated fields and relations, otherwise our parent class
        // would own them by itself:
        $this->fields = [];
        $this->relations = [];

        $relation = $this->generateRelation($namespace);
        $relation->setLocalMinMultiplicity(1);
        $relation->setLocalMaxMultiplicity(1);
        $relation->setForeignMaxMultiplicity($this->definition->getMaxItems() ?: null);
        $relation->setForeignClass($class);
        $relation->setType(RelationInterface::TYPE_COMPOSITION);
    }
}
