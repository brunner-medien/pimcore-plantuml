<?php

declare(strict_types=1);

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;
use PlantUmlBundle\Registry\RegistryInterface;

interface GeneratorServiceInterface
{
    /**
     * @return RegistryInterface
     */
    public function loadRegistry(Model\ConfigInterface $config = null);

    /**
     * @return string
     */
    public function generate(Model\ConfigInterface $config, string $name);
}
