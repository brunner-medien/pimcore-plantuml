<?php

namespace PlantUmlBundle\Service;

use PlantUmlBundle\Model;

interface ConfigurationServiceInterface
{

    /**
     * Setter dependency injection
     *
     * @param array $config
     */
    public function setConfig(array $config);

    /**
     * @return array
     */
    public function getTemplates();

    /**
     * @param string $templateName
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
     * @param string $name
     * @return Model\ConfigInterface
     * @throws \Exception
     */
    public function getConfig(string $name);

    /**
     * @param string $name
     * @throws \Exception
     */
    public function deleteConfig(string $name);

    /**
     * @param string $name
     * @param array $payload
     * @param bool $ignoreExisting
     * @throws \Exception
     */
    public function saveConfig(string $name, array $payload, bool $ignoreExisting);

    /**
     * @param $name
     * @throws \Exception
     */
    public function checkConfigName($name);


}
