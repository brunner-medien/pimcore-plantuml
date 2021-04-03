<?php

namespace PlantUmlBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PlantUmlBundle extends AbstractPimcoreBundle
{

    use PackageVersionTrait;

    /**
     * @var string
     */
    const PACKAGE_NAME = 'brunner-medien/pimcore-plantuml';

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * @return string
     */
    protected function getComposerPackageName()
    {
        return self::PACKAGE_NAME;
    }

    /**
     * @return string[]
     */
    public function getCssPaths()
    {
        return [
            '/bundles/plantuml/css/plugin.css',
        ];
    }

    /**
     * @return string[]
     */
    public function getJsPaths()
    {
        return [
            '/bundles/plantuml/js/plugin.js',
            '/bundles/plantuml/js/plantuml.js',
            '/bundles/plantuml/js/plantuml-config.js',
        ];
    }

}