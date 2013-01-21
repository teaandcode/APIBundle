<?php
/**
 * Tea and Code API Bundle Controller
 *
 * PHP version 5
 * 
 * @category Controller
 * @package  TeaAndCodeAPIBundle
 * @version  1.0
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * TeaAndCode\APIBundle\Controller\APIController
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Controller
 */
abstract class APIController extends Controller
{
    const ERR_OK = 0;

    const ERR_METHOD_NOT_FOUND = 9000;

    /**
     * Stores current error code
     * 
     * @access protected
     * @var    integer $err
     */
    protected $err;

    /**
     * Stores error messages associated with constants
     * 
     * @access protected
     * @var    array $messages
     */
    protected $messages;

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
        $this->err = self::ERR_OK;

        $this->messages = array(
            self::ERR_OK => 'OK',
            self::ERR_METHOD_NOT_FOUND =>
                'The requested method could not be found'
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
     * Handles API request
     * 
     * 1. Reads the path to find the method adjective (i.e. User)
     * 2. Reads the method to find the method verb (i.e. get)
     * 3. Adds api to beginning of method (i.e. apiGetUser)
     * 4. Checks method exists
     * 5. Reads serialised request data into Request object
     * 6. Reads both query and path data into Request object
     * 7. Obtains user object from access_token if available
     * 8. Adds the user object to the security context
     * 9. Runs function and sends error code and data as serialised Response
     * 
     * @access public
     * @param  Symfony\Component\HttpFoundation\Request $request
     * @param  string $_prefix
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function processAction(Request $request, $_prefix)
    {
        $path = str_replace($_prefix, '', $request->getPathInfo());
        $path = trim($path, '/');

        $parameters = explode('/', $path);

        if (count($parameters) == 0)
        {
            return $this->sendResponse(self::ERR_METHOD_NOT_FOUND);
        }

        $function = str_replace('-', ' ', $parameters[0]);
        $function = ucwords($function);
        $function = str_replace(' ', '', $function);
        $function = ucfirst(strtolower($request->getMethod())) . $function;
        $function = 'api' . $function;

        unset($parameters);

        if (!method_exists($this, $function))
        {
            return $this->sendResponse(self::ERR_METHOD_NOT_FOUND);
        }

        $requestClass  = 'TeaAndCode\\APIBundle\\Object\\Request';
        $requestObject = new $requestClass();

	    $content = $request->getContent();

        if (strlen($content) > 0)
        {
            $requestObject = $this->serializer->deserialize(
    			$content,
    			$requestClass,
    			$request->getRequestFormat()
    		);
	    }

        $query = $request->getQueryString();

        if (strlen($query) > 0)
        {
            parse_str($query, $parameters);

            foreach ($parameters as $name => $value)
            {
                $requestObject->setParameter($name, $value);
            }
        }

        $route = $this
            ->get('router')
            ->match($request->getPathInfo());

        foreach ($route as $name => $value)
        {
            $requestObject->setParameter($name, $value);
        }

        $accessToken = $request->getSession()->get('access_token');

        if ($requestObject->getParameter('access_token'))
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

            $this->get('security.context')->setToken(
                new UsernamePasswordToken(
                    $user,
                    null,
                    $this->container->getParameter('api_provider'),
                    $user->getRoles()
                )
            );
        }

        return $this->sendResponse($this->$function($requestObject));
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
     * Returns current error as a RuntimeException
     * 
     * @access public
     * @return RuntimeException
     */
    public function getError()
    {
        return new \RuntimeException($this->messages[$this->err], $this->err);
    }

    /**
     * Takes error code and data to form a standard serialised response array
     * 
     * @access private
     * @param  integer $err
     * @param  array $data
     * @return Symfony\Component\HttpFoundation\Response
     */
    private function sendResponse($data)
    {
        return new Response(
            $this->serializer->serialize(
                array(
                    'error' => array(
                        'code' => $this->err,
                        'message' => $this->messages[$this->err]
                    ),
                    'data' => $data
                ),
                $this->getRequest()->getRequestFormat()
            ),
            200,
            array('Content-Type' => 'text/html')
        );
    }
}