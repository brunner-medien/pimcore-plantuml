<?php

namespace PlantUmlBundle\Model;

interface ConfigInterface
{
    const CLASS_MODE_AUTO = 'auto';

    const CLASS_MODE_SKIP = 'skip';

    const CLASS_MODE_FORCE = 'force';

    const FIELD_MODE_ALL = 'all';

    const FIELD_MODE_NONE = 'none';

    const FIELD_MODE_AUTO = 'auto';

    const TRANSLATION_NONE = 'none';

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getOutputPath();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param string $classId
     * @return bool
     */
    public function getClassSeed(string $classId);

    /**
     * @param string $classId
     * @return string|null
     */
    public function getClassMode(string $classId);

    /**
     * @return string
     */
    public function getTranslation();

    /**
     * @return string
     */
    public function getFieldMode();

    /**
     * @return bool
     */
    public function getIgnoreHiddenFields();

    /**
     * @param array $config
     */
    public function fromArray(array $config);

    /**
     * @return array
     */
    public function toArray();

}