<?php

declare(strict_types=1);

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;

interface ConfigurationServiceInterface
{
    /**
     * Setter dependency injection
     */
    public function setConfig(array $config);

    /**
     * @return array
     */
    public function getTemplates();

    /**
     * @return string
     * @throws \Exception
     */
    public function getTemplatePath(string $templateName);

    /**
     * @return string
     */
    public function getRenderUrl();

    /**
     * @return array
     */
    public function listConfig();

    /**
     * @return Model\ConfigInterface
     * @throws \Exception
     */
    public function getConfig(string $name);

    /**
     * @throws \Exception
     */
    public function deleteConfig(string $name);

    /**
     * @throws \Exception
     */
    public function saveConfig(string $name, array $payload, bool $ignoreExisting);

    /**
     * @throws \Exception
     */
    public function checkConfigName(string $name);
}
