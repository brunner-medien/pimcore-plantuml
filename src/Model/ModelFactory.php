<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

class ModelFactory implements FactoryInterface
{
    /**
     * @return ClassInterface
     */
    public function buildClass()
    {
        return new ClassModel();
    }

    /**
     * @return FieldInterface
     */
    public function buildField()
    {
        return new FieldModel();
    }

    /**
     * @return RelationInterface
     */
    public function buildRelation()
    {
        return new RelationModel();
    }

    /**
     * @return ConfigInterface
     */
    public function buildConfig()
    {
        return new ConfigModel();
    }
}
