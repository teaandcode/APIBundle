<?php
/**
 * Tea and Code API Bundle Login Success Handler
 *
 * PHP version 5
 * 
 * @category Handler
 * @package  TeaAndCodeAPIBundle
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * TeaAndCode\APIBundle\Handler\LoginSuccess
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Handler
 */
class LoginSuccess implements AuthenticationSuccessHandlerInterface
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
     * Checks for app hash and sets-up API access token
     *
     * 1. Obtains hash entity based upon hash value posted by login
     * 2. If hash entity does not exist invalidate the session and return false
     * 3. Create new token entity based upon logged in user and app
     * 4. Persist the token and remove the hash entities
     * 5. Add the token id to session variable access_token
     * 6. Redirect user to the homepage specified for their role
     * 
     * @access public
     * @param  Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     * @return boolean | Symfony\Component\HttpFoundation\RedirectResponse
     */
	public function onAuthenticationSuccess(
	    Request $request, TokenInterface $token
	)
    {
		$response = null;
		$session  = $request->getSession();
		$user     = $token->getUser();

		$hash = $this
			->doctrine
			->getRepository('TheJobPostAPIBundle:Hash')
			->findOneById($request->request->get('hash'));

        foreach ($this->container->getParameter('api_roles') as $role)
        {
            if (in_array($role['name'], $user->getRoles()))
            {
                $response = new RedirectResponse(
                    $this->router->generate($role['home'])
                );
            }
        }

		if (is_null($hash) || is_null($response))
		{
			$session->invalidate();

			return new RedirectResponse(
			    $this->router->generate(
			        $this->container->getParameter('api_redirect')
			    )
			);
		}

		$user->updateLastLogin();
		$user->updateNumberOfLogins();

        $tokenEntity = $this
            ->doctrine
			->getRepository(
			    $this->container->getParameter('api_token_repository')
			)
			->create();
		$tokenEntity->setApp($hash->getApp());
		$tokenEntity->setUser($user);

		$manager = $this->doctrine->getEntityManager();
		$manager->persist($tokenEntity);
		$manager->remove($hash);
		$manager->flush();

		$session->set('access_token', $tokenEntity->getId());

        return $response;
    }
}