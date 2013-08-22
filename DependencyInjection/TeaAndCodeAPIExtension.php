<?php
/**
 * Tea and Code API Bundle DI Extension Class
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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @package TeaAndCode\APIBundle\DependencyInjection\TeaAndCodeAPIExtension
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class TeaAndCodeAPIExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @param array            $configs   Configuration options
     * @param ContainerBuilder $container Symfony2 Container
     *
     * @access public
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter(
            'api_app_repository',
            $config['database']['app_repository']
        );
        $container->setParameter(
            'api_grant_repository',
            $config['database']['grant_repository']
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
            'api_login_dialog_path',
            $config['login_dialog']['path']
        );

        $container->setParameter(
            'api_login_dialog_route',
            $config['login_dialog']['route']
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