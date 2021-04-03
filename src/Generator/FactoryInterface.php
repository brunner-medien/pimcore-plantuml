<?php

namespace PlantUmlBundle\Generator;

interface FactoryInterface
{

    /**
     * @param object $definition
     * @return GeneratorInterface|null
     */
    public function buildGenerator(object $definition);

}
