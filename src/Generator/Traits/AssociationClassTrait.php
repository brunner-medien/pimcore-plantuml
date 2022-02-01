<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Traits;

use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\ModelInterface;
use PlantUmlBundle\Model\RelationInterface;

trait AssociationClassTrait
{
    /**
     * @return ClassInterface|null
     */
    protected function processAllowedClasses(array $namespace, RelationInterface $relation, array $allowedClasses, bool $active)
    {
        $foreignClass = null;

        if (count($allowedClasses) === 1) {
            $item = $allowedClasses[0];
            $foreignClass = $this->generateClass($item['namespace'], $item['class'], $active);
            $relation->setForeignClass($foreignClass);
        } elseif (count($allowedClasses) > 1) {

            // watch this:
            // we generate another namespace level for the association class here,
            // because $namespace/$foreignClassname is already in use for the
            // relation class if we have an *advanced* many-to- relation here:

            $foreignClassName = ucfirst($this->definition->getName());
            $foreignClass = $this->generateClass(array_merge($namespace, [$foreignClassName]), ModelInterface::CLASS_ASSOCIATION, $active);

            $foreignClass->setIsAssociationClass(true);
            $relation->setForeignClass($foreignClass);

            foreach ($allowedClasses as $item) {
                $itemClass = $this->generateClass($item['namespace'], $item['class'], $active);
                $itemClass->addRealizeClass($foreignClass);
            }
        }

        return $foreignClass;
    }
}
