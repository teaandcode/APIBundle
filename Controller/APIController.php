<?php
/**
 * Tea and Code API Bundle Controller
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\Controller
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * TeaAndCode\APIBundle\Controller\APIController
 *
 * @package TeaAndCode\APIBundle\Controller\APIController
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
abstract class APIController extends Controller
{
    const ERR_OK = 0;
    const ERR_APP_ID_NOT_SET    = 9000;
    const ERR_APP_NOT_FOUND     = 9001;
    const ERR_METHOD_NOT_FOUND  = 9002;
    const ERR_REDIRECT_MISMATCH = 9003;

    /**
     * Stores current error code
     *
     * @access protected
     * @var    integer $err
     */
    protected $err;

    /**
     * ResponseHeaderBag
     *
     * @access protected
     * @var    ResponseHeaderBag $headers
     */
    protected $headers;

    /**
     * Stores error messages associated with constants
     *
     * @access protected
     * @var    array $messages
     */
    protected $messages;

    /**
     * Symfony Request object
     *
     * @access protected
     * @var    Symfony\Component\HttpFoundation\Request $request
     */
    protected $request;

    /**
     * Serializer used to serialize and unserialize data into/from JSON or XML
     *
     * @access protected
     * @var    Symfony\Component\Serializer\Serializer $serializer
     */
    protected $serializer;

    /**
     * Pre-fills messages array and sets-up the JSON/XML serializer
     *
     * @access public
     * @return TeaAndCode\APIBundle\Controller\APIController
     */
    public function __construct()
    {
        $this->err = static::ERR_OK;

        $this->headers = new ResponseHeaderBag();
        $this->headers->add(
            array(
                'Access-Control-Allow-Origin' => '*',
                'Content-Type'                => 'text/html'
            )
        );

        $this->messages = array(
            static::ERR_OK => 'OK',
            static::ERR_APP_ID_NOT_SET    => 'The app_id is not set',
            static::ERR_APP_NOT_FOUND     => 'No app entity was found',
            static::ERR_METHOD_NOT_FOUND  => 'The method could not be found',
            static::ERR_REDIRECT_MISMATCH => 'The redirect uri does not ' .
                                             'match the app domain'
        );

        $this->serializer = new Serializer(
            array(
                new GetSetMethodNormalizer()
            ),
            array(
                'json' => new JsonEncoder(),
                'xml'  => new XmlEncoder()
            )
        );
    }

    /**
     * Returns current error as a RuntimeException
     *
     * @param integer $code Specific error code
     *
     * @access public
     * @return RuntimeException
     */
    public function getError($code = self::ERR_OK)
    {
        if ($code == self::ERR_OK || !isset($this->messages[$code]))
        {
            $code = $this->err;
        }

        return new \RuntimeException($this->messages[$code], $code);
    }

    /**
     * Returns ResponseHeaderBag
     *
     * @access public
     * @return ResponseHeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns error messages
     *
     * @access public
     * @return array
     */
    public function getMessagesAction()
    {
        return $this->render(
            'TeaAndCodeAPIBundle:API:messages.html.twig',
            array(
                'messages' => $this->messages
            )
        );
    }

    /**
     * Handles API request
     *
     * @param Request $request Symfony Request object
     * @param string  $_prefix API URL prefix
     *
     * @access public
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function processAction(Request $request, $_prefix = '')
    {
        $this->request = $request;

        // Reads the path to find the object (i.e. User)
        $path = str_replace($_prefix, '', $this->request->getPathInfo());
        $path = trim($path, '/');

        $parameters = explode('/', $path);

        if (count($parameters) == 0)
        {
            $this->err = static::ERR_METHOD_NOT_FOUND;

            return $this->sendResponse();
        }

        $object = str_replace('-', ' ', $parameters[0]);
        $object = ucwords($object);
        $object = str_replace(' ', '', $object);

        // Reads the method to find the action (i.e. get)
        $action = ucfirst(strtolower($this->request->getMethod()));

        // Adds api to the beginning to form the name of the function
        $function = 'api' . $action . $object;

        unset($parameters);

        // Checks the method exists
        if (!method_exists($this, $function))
        {
            $this->err = static::ERR_METHOD_NOT_FOUND;

            return $this->sendResponse();
        }

        $requestClass  = 'TeaAndCode\\APIBundle\\Object\\Request';
        $requestObject = new $requestClass();

        $content = $this->request->getContent();

        // Reads serialised request data into Request object
        if (strlen($content) > 0)
        {
            $requestObject = $this->serializer->deserialize(
                $content,
                $requestClass,
                $this->request->getRequestFormat()
            );
        }

        // Reads both query and path data into Request object
        $query = $this->request->getQueryString();

        if (strlen($query) > 0)
        {
            parse_str($query, $parameters);

            foreach ($parameters as $name => $value)
            {
                if (!$requestObject->isParameterSet($name))
                {
                    $requestObject->setParameter($name, $value);
                }
            }
        }

        $route = $this
            ->get('router')
            ->match($this->request->getPathInfo());

        foreach ($route as $name => $value)
        {
            if (!$requestObject->isParameterSet($name))
            {
                $requestObject->setParameter($name, $value);
            }
        }

        // Obtains user object from access_token if available
        $accessToken = $this->request->getSession()->get('access_token');

        if ($requestObject->isParameterSet('access_token'))
        {
            $accessToken = $requestObject->getParameter('access_token');
        }

        $token = $this
            ->get('doctrine')
            ->getRepository(
                $this->container->getParameter('api_token_repository')
            )
            ->findOneById($accessToken);

        if ($token)
        {
            $user = $token->getUser();

            // Adds the user object to the security context
            $this->get('security.context')->setToken(
                new UsernamePasswordToken(
                    $user,
                    null,
                    $this->container->getParameter('api_provider'),
                    $user->getRoles()
                )
            );
        }

        // Returns sendResponse parsed output from function
        return $this->sendResponse($this->$function($requestObject));
    }

    /**
     * Takes error code and data to form a standard serialised response array
     *
     * @param array $data Data returned from API method as an array
     *
     * @access protected
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function sendResponse($data = null)
    {
        $response = new Response();

        $response->setContent(
            $this->serializer->serialize(
                array(
                    'error' => array(
                        'code' => $this->err,
                        'message' => $this->messages[$this->err]
                    ),
                    'data' => $this->_removeUnderscores($data)
                ),
                $this->request->getRequestFormat()
            )
        );

        $response->headers = $this->headers;
        $response->setProtocolVersion('1.1');

        if ($this->err == static::ERR_OK)
        {
            $response->setStatusCode(200);
        }
        else
        {
            $response->setStatusCode(400);
        }
/*
        $response = new Response(
            $this->serializer->serialize(
                array(
                    'error' => array(
                        'code' => $this->err,
                        'message' => $this->messages[$this->err]
                    ),
                    'data' => $this->_removeUnderscores($data)
                ),
                $this->request->getRequestFormat()
            ),
            $code,
            array(
                'Access-Control-Allow-Origin'     => '*',
                'Content-Type'                    => 'text/html'
            )
        );
*/
        return $response;
    }

    /**
     * Removes underscored (private) keys from array before sending out to the
     * output buffer
     *
     * @param mixed $data Data returned from API method as an array
     *
     * @access private
     * @return mixed
     */
    private function _removeUnderscores($data)
    {
        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                if (substr($key, 0, 1) == '_')
                {
                    unset($data[$key]);
                }
                elseif (is_array($value))
                {
                    $data[$key] = $this->_removeUnderscores($value);
                }
            }
        }

        return $data;
    }
}