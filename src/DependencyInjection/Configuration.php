<?php

declare(strict_types=1);

namespace PlantUmlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('plant_uml');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('templates')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('path')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('render_url')
                    ->defaultValue('https://www.plantuml.com/plantuml/uml/')
                    ->info('The URL of the PlantUML server. Enter your local one, otherwise plantuml.com is used.')
                ->end();

        return $treeBuilder;
    }
}
