<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('manhattan_public');

        $rootNode
            ->children()
                ->arrayNode('analytics')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('property')
                            ->defaultValue('')
                            ->info('Set the Analytics Property')
                            ->end()
                    ->end()
                ->end()
                ->arrayNode('emails')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('from')
                            ->defaultValue('webmaster@website.com')
                            ->info('Sets the From address when an email is sent')
                            ->end()
                        ->arrayNode('contact')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('subject')
                                    ->defaultValue('Contact Email')
                                    ->info('Sets the Subject for a Welcome email when member is created')
                                    ->end()
                                ->scalarNode('to')->defaultValue('webmaster@website.com')->end()
                                ->scalarNode('template_html')->defaultValue('ManhattanPublicBundle:Email:contact.html.twig')->end()
                                ->scalarNode('template_txt')->defaultValue('ManhattanPublicBundle:Email:contact.txt.twig')->end()
                                ->scalarNode('sendgrid_category')->defaultValue('Contact Email')->end()

                                ->arrayNode('subjects')
                                    ->defaultValue(array(
                                        'general' => 'General Enquiry',
                                        'support' => 'Support Request'
                                    ))
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
