<?php

namespace PlantUmlBundle\Generator\Relation;

use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\ClassInterface;
use PlantUmlBundle\Model\ModelInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;

/**
 * @property Data $definition
 */
abstract class AbstractRelationGenerator extends AbstractGenerator implements GeneratorInterface
{

    /**
     * @return array
     */
    protected function getAllowedClasses()
    {
        $allowedClasses = [];

        if (method_exists($this->definition, 'getAllowedClassId')) {

            if ($allowedClass = $this->definition->getAllowedClassId()) {
                $allowedClasses[] = [
                    'namespace' => [ModelInterface::CLASS_OBJECT],
                    'class' => $allowedClass
                ];
            }

        } elseif ($this->definition->getObjectsAllowed()) {
            if (empty($this->definition->getClasses())) {
                $allowedClasses[] = [
                    'namespace' => [],
                    'class' => ModelInterface::CLASS_OBJECT
                ];
            } else {
                foreach ($this->definition->getClasses() as $item) {
                    $allowedClasses[] = [
                        'namespace' => [ModelInterface::CLASS_OBJECT],
                        'class' => $item['classes']
                    ];
                }
            }
        }

        if (
            method_exists($this->definition, 'getAssetsAllowed')
                &&
            $this->definition->getAssetsAllowed()
        ) {
            if (empty($this->definition->getAssetTypes())) {
                $allowedClasses[] = [
                    'namespace' => [],
                    'class' => ModelInterface::CLASS_ASSET
                ];
            } else {
                foreach ($this->definition->getAssetTypes() as $item) {
                    $allowedClasses[] = [
                        'namespace' => [ModelInterface::CLASS_ASSET],
                        'class' => ucfirst($item['assetTypes'])
                    ];
                }
            }
        }

        if (
            method_exists($this->definition, 'getDocumentsAllowed')

            &&
            $this->definition->getDocumentsAllowed()
        ) {
            if (empty($this->definition->getDocumentTypes())) {
                $allowedClasses[] = [
                    'namespace' => [],
                    'class' => ModelInterface::CLASS_DOCUMENT
                ];
            } else {
                foreach ($this->definition->getDocumentTypes() as $item) {
                    $allowedClasses[] = [
                        'namespace' => [ModelInterface::CLASS_DOCUMENT],
                        'class' => ucfirst($item['documentTypes'])
                    ];
                }
            }
        }

        return $allowedClasses;
    }

}