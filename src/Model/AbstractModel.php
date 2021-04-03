<?php

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
     * @param array $namespace
     * @param string $name
     * @return string
     */
    public static function generateNamespaceName(array $namespace, string $name)
    {
        return implode('\\', array_merge($namespace, [$name]));
    }

    /**
     * @param $groupId
     * @return string
     */
    public static function generateClassificationGroupName($groupId)
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

    /**
     * @param string $name
     */
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

    /**
     * @param array $namespace
     */
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
