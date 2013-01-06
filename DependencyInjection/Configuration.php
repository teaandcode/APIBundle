<?php
/**
 * Tea and Code API Bundle DI Configuration Class
 *
 * PHP version 5
 * 
 * @category DI Configuration Class
 * @package  TeaAndCodeAPIBundle
 * @version  1.0
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 * 
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 * 
 * @package    TeaAndCodeAPIBundle
 * @subpackage DI Configuration Class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('tea_and_code_api')
            ->children()
                ->arrayNode('database')
                    ->children()
                        ->scalarNode('app_repository')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('hash_repository')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('token_repository')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('user_repository')
                            ->isRequired(true)
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('redirect')
                    ->isRequired(true)
                ->end()
                ->arrayNode('roles')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired(true)
                            ->end()
                            ->scalarNode('home')
                                ->isRequired(true)
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('security')
                    ->children()
                        ->scalarNode('provider')
                            ->isRequired(true)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}