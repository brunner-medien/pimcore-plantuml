<?php

declare(strict_types=1);

namespace PlantUmlBundle\Generator;

interface FactoryInterface
{
    /**
     * @return GeneratorInterface|null
     */
    public function buildGenerator(object $definition);
}
