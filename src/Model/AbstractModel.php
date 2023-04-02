<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

abstract class AbstractModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $namespace = [];

    /**
     * @return string
     */
    public static function generateNamespaceName(array $namespace, string $name)
    {
        return implode('\\', array_merge($namespace, [$name]));
    }

    /**
     * @return string
     */
    public static function generateClassificationGroupName(?int $groupId)
    {
        return implode('_', [ModelInterface::CLASS_CLASSIFICATION_GROUP, $groupId]);
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return self::generateNamespaceName($this->namespace, $this->name);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setNamespace(array $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string[]
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
