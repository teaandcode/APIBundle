<?php
/**
 * Tea and Code API Bundle DI Configuration Class
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\DependencyInjection
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * TeaAndCode\APIBundle\DependencyInjection\Configuration
 *
 * @package TeaAndCode\APIBundle\DependencyInjection\Configuration
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     *
     * @access public
     * @return Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        // @codingStandardsIgnoreStart
        $rootNode = $treeBuilder->root('tea_and_code_api')
            ->children()
                ->arrayNode('database')
                    ->children()
                        ->scalarNode('app_repository')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('grant_repository')
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
                ->scalarNode('host')
                    ->isRequired(true)
                ->end()
                ->arrayNode('login_dialog')
                    ->children()
                        ->scalarNode('path')
                            ->isRequired(true)
                        ->end()
                        ->scalarNode('route')
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
        // @codingStandardsIgnoreEnd

        return $treeBuilder;
    }
}