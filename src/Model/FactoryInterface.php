<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface FactoryInterface
{
    /**
     * @return ClassInterface
     */
    public function buildClass();

    /**
     * @return FieldInterface
     */
    public function buildField();

    /**
     * @return RelationInterface
     */
    public function buildRelation();

    /**
     * @return ConfigInterface
     */
    public function buildConfig();
}
