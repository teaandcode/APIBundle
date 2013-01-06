<?php
/**
 * Tea and Code API Bundle DI Extension Class
 *
 * PHP version 5
 * 
 * @category DI Extension Class
 * @package  TeaAndCodeAPIBundle
 * @version  1.0
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 * 
 * @package    TeaAndCodeAPIBundle
 * @subpackage DI Extension Class
 */
class TeaAndCodeAPIExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter(
            'api_app_repository',
            $config['database']['app_repository']
        );
        $container->setParameter(
            'api_hash_repository',
            $config['database']['hash_repository']
        );
        $container->setParameter(
            'api_token_repository',
            $config['database']['token_repository']
        );
        $container->setParameter(
            'api_user_repository',
            $config['database']['user_repository']
        );

        $container->setParameter(
            'api_redirect',
            $config['redirect']
        );

        $container->setParameter(
            'api_roles',
            $config['roles']
        );

        $container->setParameter(
            'api_provider',
            $config['security']['provider']
        );

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}