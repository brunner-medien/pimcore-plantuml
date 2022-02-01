<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface ConfigInterface
{
    public const CLASS_MODE_AUTO = 'auto';

    public const CLASS_MODE_SKIP = 'skip';

    public const CLASS_MODE_FORCE = 'force';

    public const FIELD_MODE_ALL = 'all';

    public const FIELD_MODE_NONE = 'none';

    public const FIELD_MODE_AUTO = 'auto';

    public const TRANSLATION_NONE = 'none';

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
     * @return bool
     */
    public function getClassSeed(string $classId);

    /**
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

    public function fromArray(array $config);

    /**
     * @return array
     */
    public function toArray();
}
