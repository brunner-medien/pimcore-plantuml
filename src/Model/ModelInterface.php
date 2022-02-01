<?php

declare(strict_types=1);

namespace PlantUmlBundle\Model;

interface ModelInterface
{
    public const CLASS_ASSOCIATION = 'Association';

    public const CLASS_FIELD_COLLECTION = 'FieldCollection';

    public const CLASS_CLASSIFICATION = 'Classification';

    public const CLASS_OBJECT_BRICK = 'ObjectBrick';

    public const CLASS_CLASSIFICATION_GROUP = 'Group';

    public const CLASS_OBJECT = 'Object';

    public const CLASS_DOCUMENT = 'Document';

    public const CLASS_ASSET = 'Asset';

    public const CLASS_ASSET_IMAGE = 'Image';

    public const CLASS_ASSET_VIDEO = 'Video';

    public const STEREOTYPE_OBJECT = 'object';

    public const STEREOTYPE_DOCUMENT = 'document';

    public const STEREOTYPE_ASSET = 'asset';

    public const STEREOTYPE_BLOCK = 'block';

    public const STEREOTYPE_CLASSIFICATION_GROUP = 'classification';

    public const STEREOTYPE_FIELDCOLLECTION = 'fieldcollection';

    public const STEREOTYPE_OBJECTBRICK = 'objectbrick';

    public const STEREOTYPE_RELATION = 'relation';

    /**
     * @return string
     */
    public function getNamespaceName();

    public function setName(string $name);

    /**
     * @return string
     */
    public function getName();

    public function setNamespace(array $namespace);

    /**
     * @return string[]
     */
    public function getNamespace();
}
