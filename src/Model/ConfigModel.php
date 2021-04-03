<?php

namespace PlantUmlBundle\Model;

class ConfigModel implements ConfigInterface
{
    /**
     * @var bool[]
     */
    protected $classSeed = [];

    /**
     * @var array
     */
    protected $classMode = [];

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $outputPath;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string|null
     */
    protected $fieldMode;

    /**
     * @var bool
     */
    protected $ignoreHiddenFields = false;

    /**
     * @var string|null
     */
    protected $translation;

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getOutputPath()
    {
        return $this->outputPath ?: '';
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template ?: 'Default';
    }

    /**
     * @param string $classId
     * @return bool
     */
    public function getClassSeed(string $classId)
    {
        return $this->classSeed[$classId] ?? false;
    }

    /**
     * @param string $classId
     * @return string|null
     */
    public function getClassMode(string $classId)
    {
        return $this->classMode[$classId] ?? ConfigInterface::CLASS_MODE_AUTO;
    }

    /**
     * @return string
     */
    public function getFieldMode()
    {
        return $this->fieldMode ?: ConfigInterface::FIELD_MODE_AUTO;
    }

    /**
     * @return bool
     */
    public function getIgnoreHiddenFields()
    {
        return $this->ignoreHiddenFields;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation ?: ConfigInterface::TRANSLATION_NONE;
    }

    /**
     * @param array $config
     */
    public function fromArray(array $config)
    {
        if (array_key_exists('classSeed', $config) && is_array($config['classSeed'])) {
            $this->classSeed = [];
            foreach ($config['classSeed'] as $id => $classSeed) {
                if ($classSeed) {
                    $this->classSeed[$id] = true;
                }
            }
        }
        if (array_key_exists('classMode', $config)) {
            $this->classMode = [];
            foreach ($config['classMode'] as $id => $classMode) {
                if (is_string($classMode) && in_array($classMode, [
                        ConfigInterface::CLASS_MODE_FORCE,
                        ConfigInterface::CLASS_MODE_SKIP
                ])) {
                    $this->classMode[$id] = $classMode;
                }
            }
        }

        if (array_key_exists('title', $config) && is_string($config['title'])) {
            $this->title = $config['title'];
        }

        if (array_key_exists('outputPath', $config) && is_string($config['outputPath'])) {
            $this->outputPath = $config['outputPath'];
        }

        if (array_key_exists('template', $config) && is_string($config['template'])) {
            $this->template = $config['template'];
        } else {
            $this->template = $this->getTemplate(); // keep or set to default
        }

        if (array_key_exists('fieldMode', $config) && is_string($config['fieldMode'])) {
            $this->fieldMode = $config['fieldMode'];
        } else {
            $this->fieldMode = $this->getFieldMode(); // keep or set to default
        }

        if (array_key_exists('translation', $config) && is_string($config['translation'])) {
            $this->translation = $config['translation'];
        } else {
            $this->translation = $this->getTranslation(); // keep or set to default
        }

        if (array_key_exists('ignoreHiddenFields', $config) && is_scalar($config['ignoreHiddenFields'])) {
            $this->ignoreHiddenFields = !!$config['ignoreHiddenFields'];
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'outputPath' => $this->outputPath,
            'template' => $this->template,
            'fieldMode' => $this->fieldMode,
            'classSeed' => $this->classSeed,
            'classMode' => $this->classMode,
            'translation' => $this->translation,
            'ignoreHiddenFields' => $this->ignoreHiddenFields,
        ];
    }

}