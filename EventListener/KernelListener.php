<?php
/**
 * Tea and Code API Bundle Kernel Event Listener
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\EventListener
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use TeaAndCode\APIBundle\Controller\APIController;

/**
 * This class listens for Kernel events
 *
 * @package TeaAndCode\APIBundle\EventListener\KernelListener
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class KernelListener extends APIController
{
    /**
     * Sets-up environment with services arguments
     *
     * @param Doctrine  $doctrine  Doctrine object
     * @param Container $container Container object
     *
     * @access public
     * @return TeaAndCode\APIBundle\EventListener\KernelListener
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);

        parent::__construct();
    }

    /**
     * Runs on kernel request
     *
     * @param GetResponseEvent $event Response event
     *
     * @access public
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $this->request = $event->getRequest();

        $loginDialog = $this->container->getParameter('api_login_dialog_path');
        $pathInfo    = pathinfo($this->request->getPathInfo());

        if ($pathInfo['dirname'] . $pathInfo['filename'] == $loginDialog)
        {
            $this->request->setRequestFormat('json');

            if (isset($pathInfo['extension']))
            {
                $format = strtolower($pathInfo['extension']);

                if ($format == 'xml')
                {
                    $this->request->setRequestFormat('xml');
                }
            }

            parse_str($this->request->getQueryString(), $query);

            if (!isset($query['app_id']))
            {
                $this->err = static::ERR_APP_ID_NOT_SET;
                $event->setResponse($this->sendResponse());

                return;
            }

            $app = null;

            if (isset($parameters['app_secret']))
            {
                $app = $this
                    ->get('doctrine')
                    ->getRepository(
                        $this->container->getParameter('api_app_repository')
                    )
                    ->getByAppIdAndAppSecret(
                        $query['app_id'],
                        $query['app_secret']
                    );
            }
            else
            {
                $referer = parse_url($this->request->headers->get('referer'));

                if (isset($referer['host']))
                {
                    $app = $this
                        ->get('doctrine')
                        ->getRepository(
                            $this->container->getParameter('api_app_repository')
                        )
                        ->getByAppIdAndAppDomain(
                            $query['app_id'],
                            $referer['host']
                        );
                }
            }

            if (is_null($app))
            {
                $this->err = static::ERR_APP_NOT_FOUND;
                $event->setResponse($this->sendResponse());

                return;
            }

            $event->setResponse(
                $this->sendResponse(
                    array(
                        'url' => 'http://www.foo.com?hash=1234567890'
                    )
                )
            );
        }
    }
}