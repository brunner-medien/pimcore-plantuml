<?php

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;
use PlantUmlBundle\Registry\RegistryInterface;

interface GeneratorServiceInterface
{

    /**
     * @param Model\ConfigInterface|null $config
     * @return RegistryInterface
     */
    public function loadRegistry(Model\ConfigInterface $config = null);

    /**
     * @param Model\ConfigInterface $config
     * @param string $name
     * @return string
     */
    public function generate(Model\ConfigInterface $config, string $name);

}