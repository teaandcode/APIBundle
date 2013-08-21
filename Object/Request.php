<?php
/**
 * Tea and Code API Bundle Request Object
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\Object
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\Object;

/**
 * This class contains all the relevant request information
 *
 * @package TeaAndCode\APIBundle\Interfaces\IApp
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class Request
{
    /**
     * Stores all parameters from the request
     *
     * @access private
     * @var    array $parameters
     */
    private $_parameters;

    /**
     * Class constructor
     *
     * @param array $parameters Array containing request parameters
     *
     * @access public
     * @return void
     */
    public function __construct(array $parameters = array())
    {
        $this->_parameters = $parameters;
    }

    /**
     * Set parameters from request
     *
     * @param array $parameters Array containing request parameters
     *
     * @access public
     * @return void
     */
    public function setParameters(array $parameters)
    {
        if (is_array($parameters))
        {
            $this->_parameters = $parameters;
        }
    }

    /**
     * Get all parameters from request
     *
     * @access public
     * @return array
     */
    public function getParameters()
    {
        if (count($this->_parameters) > 0)
        {
            return $this->_parameters;
        }

        return false;
    }

    /**
     * Set single parameter from request
     *
     * @param string $name  The parameter's name
     * @param string $value The parameter's value
     *
     * @access public
     * @return void
     */
    public function setParameter($name, $value)
    {
        if (!is_array($this->_parameters))
        {
            $this->_parameters = array();
        }

        $this->_parameters[$name] = $value;
    }

    /**
     * Get single parameter from request
     *
     * @param string $name The parameter's name
     *
     * @access public
     * @return mixed
     */
    public function getParameter($name)
    {
        if (isset($this->_parameters[$name]))
        {
            if (is_array($this->_parameters[$name]))
            {
                if (count($this->_parameters[$name]) == 0)
                {
                    return false;
                }
            }

            if (empty($this->_parameters[$name]))
            {
                return false;
            }

            return $this->_parameters[$name];
        }

        return false;
    }

    /**
     * Check if single parameter is set
     *
     * @param string $name The parameter's name
     *
     * @access public
     * @return boolean
     */
    public function isParameterSet($name)
    {
        if (isset($this->_parameters[$name]))
        {
            return true;
        }

        return false;
    }
}