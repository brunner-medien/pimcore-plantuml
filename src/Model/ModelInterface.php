<?php

namespace PlantUmlBundle\Model;

interface ModelInterface
{

    const CLASS_ASSOCIATION = 'Association';
    const CLASS_FIELD_COLLECTION = 'FieldCollection';
    const CLASS_CLASSIFICATION = 'Classification';
    const CLASS_OBJECT_BRICK = 'ObjectBrick';
    const CLASS_CLASSIFICATION_GROUP = 'Group';
    const CLASS_OBJECT = 'Object';
    const CLASS_DOCUMENT = 'Document';
    const CLASS_ASSET = 'Asset';
    const CLASS_ASSET_IMAGE = 'Image';
    const CLASS_ASSET_VIDEO = 'Video';

    const STEREOTYPE_OBJECT = 'object';
    const STEREOTYPE_DOCUMENT = 'document';
    const STEREOTYPE_ASSET = 'asset';
    const STEREOTYPE_BLOCK = 'block';
    const STEREOTYPE_CLASSIFICATION_GROUP = 'classification';
    const STEREOTYPE_FIELDCOLLECTION = 'fieldcollection';
    const STEREOTYPE_OBJECTBRICK = 'objectbrick';
    const STEREOTYPE_RELATION = 'relation';

    /**
     * @return string
     */
    public function getNamespaceName();

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param array $namespace
     */
    public function setNamespace(array $namespace);

    /**
     * @return string[]
     */
    public function getNamespace();

}
