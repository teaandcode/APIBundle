<?php
/**
 * Tea and Code API Bundle Login Success Handler
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
use Symfony\Component\Security\Http\Authentication;
use Symfony\Component\Security\Core\Authentication\Token;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * This class runs on successful login
 *
 * @package TeaAndCode\APIBundle\Handler\LoginSuccess
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
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
     * Checks for app hash and sets-up API access token
     *
     * 1. Obtains hash entity based upon hash value posted by login
     * 2. If hash entity does not exist invalidate the session and return false
     * 3. Create new token entity based upon logged in user and app
     * 4. Persist the token and remove the hash entities
     * 5. Add the token id to session variable access_token
     * 6. Redirect user to the homepage specified for their role
     *
     * @param Request        $request Request object
     * @param TokenInterface $token   Token object
     *
     * @access public
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token
    )
    {
        $app     = null;
        $current = parse_url($this->container->getParameter('api_host'));
        $hash    = $request->request->get('hash');
        $referer = parse_url($request->headers->get('referer'));
        $role    = null;
        $user    = $token->getUser();

        // Check user role exists in configuration and set the first role found,
        // roles with more privileges should always go towards the top of the
        // list in the configuration

        foreach ($this->container->getParameter('api_roles') as $apiRole)
        {
            if (in_array($apiRole['name'], $user->getRoles()))
            {
                $role = $apiRole;

                break;
            }
        }

        // If no role is found, redirect user to api_redirect route in
        // configuration

        if (is_null($role) || $current['host'] != $referer['host'])
        {
            $request->getSession()->invalidate();

            return new RedirectResponse(
                $this->router->generate(
                    $this->container->getParameter('api_redirect')
                )
            );
        }

        // Check if an app is requesting a login using the hash previously set
        // when the login screen was requested.

        if (!is_null($hash))
        {
            $app = $this
                ->doctrine
                ->getRepository(
                    $this->container->getParameter('api_app_repository')
                )
                ->getByHashId($hash);
        }

        // Update user's last login to now and increment the number of logins

        $user->updateLastLogin();
        $user->updateNumberOfLogins();

        // If no app was found, redirect the user to their home page (this is
        // assumed the user is logging into the website)

        if (is_null($app))
        {
            return new RedirectResponse($this->router->generate($role['home']));
        }

        // Needs to check for trusted status or granted permissions



        // Creates Token entity for app and user and persists in the database

        $tokenEntity = $this
            ->doctrine
            ->getRepository(
                $this->container->getParameter('api_token_repository')
            )
            ->create();

        $tokenEntity->setApp($app);
        $tokenEntity->setUser($user);

        $manager = $this->doctrine->getEntityManager();
        $manager->persist($tokenEntity);
        $manager->flush();

        $accessToken = $tokenEntity->getId();
        $expiresIn   = $tokenEntity->getExpires()->format('U');
        $redirectUri = $request->request->get('redirect_uri');

        // The session is invalidated as the access_token is used to
        // authenticate the user on each request

        $request->getSession()->invalidate();

        // Checks whether a redirect_uri was set and if so relays access_token,
        // expires_in and user_id back to redirect_uri

        if (!is_null($redirectUri))
        {
            $redirect = parse_url($redirectUri);

            if ($redirect !== false)
            {
                $url = $redirect['scheme'] . '://';

                if (isset($redirect['user']) && isset($redirect['pass']))
                {
                    $url .= $redirect['user'] . ':' . $redirect['pass'] . '@';
                }

                $url .= $redirect['host'];
                $url .= $redirect['path'];
                $url .= '?';

                if (isset($redirect['query']))
                {
                    $url .= $redirect['query'] . '&';
                }

                $url .= 'access_token=' . $accessToken;
                $url .= '&expires_in=' . $expiresIn;
                $url .= '&user_id=' . $user->getId();

                return new RedirectResponse($url);
            }
        }

        // Sets default return format and creates serializer for JSON and XML

        $format     = 'json';
        $requested  = $request->request->get('requested_format');
        $serializer = new Serializer(
            array(
                new GetSetMethodNormalizer()
            ),
            array(
                'json' => new JsonEncoder(),
                'xml'  => new XmlEncoder()
            )
        );

        // Changes return format to XML if requested

        if (!is_null($requested))
        {
            if (strtolower($requested) == 'xml')
            {
                $format = 'xml';
            }
        }

        // Returns access_token, expires_in and user_id in format set

        return new Response(
            $serializer->serialize(
                array(
                    'access_token' => $accessToken,
                    'expires_in'   => $expiresIn,
                    'user_id'      => $user->getId()
                ),
                $format
            ),
            200,
            array('Content-Type' => 'text/html')
        );        
    }
}