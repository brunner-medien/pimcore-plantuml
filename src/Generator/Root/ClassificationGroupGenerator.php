<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator\Root;

use Pimcore\Model\DataObject\Classificationstore;
use PlantUmlBundle\Generator\AbstractGenerator;
use PlantUmlBundle\Generator\GeneratorInterface;
use PlantUmlBundle\Model\AbstractModel;
use PlantUmlBundle\Model\ModelInterface;

/**
 * @property Classificationstore\GroupConfig $definition
 */
class ClassificationGroupGenerator extends AbstractGenerator implements GeneratorInterface
{
    /**
     * @param string[] $namespace
     * @throws \Exception
     */
    public function generate(array $namespace, bool $active = false)
    {
        $classname = AbstractModel::generateClassificationGroupName($this->definition->getId());
        $classNamespace = array_merge($namespace, [$classname]);
        $class = $this->generateClass($namespace, $classname, $active);
        $class->setTitle($this->definition->getName());
        $class->setStereotype(ModelInterface::STEREOTYPE_CLASSIFICATION_GROUP);

        $listing = new Classificationstore\KeyGroupRelation\Listing();
        $listing->setCondition('groupId = ?', $this->definition->getId());
        $listing->setOrderKey('sorter');
        $listing->setOrder('ASC');

        foreach ($listing->load() as $item) {
            $keyConfig = Classificationstore\DefinitionCache::get($item->getKeyId());
            $fieldDefinition = Classificationstore\Service::getFieldDefinitionFromKeyConfig($keyConfig);

            if ($generator = $this->factory->buildGenerator($fieldDefinition)) {
                $generator->generate($classNamespace, $active);

                foreach ($generator->getFields() as $field) {
                    $this->fields[] = $field;
                    $class->addField($field);
                }
            }
        }
    }
}
