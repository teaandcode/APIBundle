<?php
/**
 * Tea and Code API Bundle Login Failure Handler
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\Handler
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication;

/**
 * This class runs on login failure
 *
 * @package TeaAndCode\APIBundle\Handler\LoginSuccess
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class LoginFailure
implements Authentication\AuthenticationFailureHandlerInterface
{
    /**
     * Stores container object
     *
     * @access protected
     * @var    Symfony\Component\DependencyInjection\Container $container
     */
    protected $container;

    /**
     * Stores doctrine object
     *
     * @access protected
     * @var    Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     */
    protected $doctrine;

    /**
     * Stores router object
     *
     * @access protected
     * @var    Symfony\Component\Routing\Router $router
     */
    protected $router;

    /**
     * Sets-up environment with services arguments
     *
     * @param Doctrine  $doctrine  Doctrine object
     * @param Router    $router    Router object
     * @param Container $container Container object
     *
     * @access public
     * @return TeaAndCode\APIBundle\EventListener\LoginListener
     */
    public function __construct(
        Doctrine $doctrine,
        Router $router,
        Container $container
    )
    {
        $this->container = $container;
        $this->doctrine  = $doctrine;
        $this->router    = $router;
    }

    /**
     * Redirects user back to their login channel
     *
     * @param Request                 $request   Request object
     * @param AuthenticationException $exception Authentication Exception
     *
     * @access public
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    )
    {
        $request->getSession()->set(
            SecurityContext::AUTHENTICATION_ERROR,
            $exception
        );

        $hash = $request->request->get('hash');

        if (is_null($hash))
        {
            error_log('foo');
        }

        return new RedirectResponse(
            $this
                ->router
                ->generate(
                    $this
                        ->container
                        ->getParameter('api_login_dialog_route'),
                    array('hash' => $hash),
                    true
                )
        );
    }
}