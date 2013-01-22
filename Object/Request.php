<?php
/**
 * Tea and Code API Bundle Request Object
 *
 * PHP version 5
 * 
 * @category RequestObject
 * @package  TeaAndCodeAPIBundle
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\Object;

/**
 * TeaAndCode\APIBundle\Object\Request
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage RequestObject
 */
class Request
{
    /**
     * Stores all parameters from the request
     * 
     * @access private
     * @var    array $parameters
     */
    private $parameters;

    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Set parameters from request
     * 
     * @access public
     * @param  array $parameters
     */
    public function setParameters(array $parameters)
    {
        if (is_array($parameters))
        {
            $this->parameters = $parameters;
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
        if (count($this->parameters) > 0)
        {
            return $this->parameters;
        }

        return false;
    }

    /**
     * Set single parameter from request
     * 
     * @access public
     * @param  string $name
     * @param  string $value
     */
    public function setParameter($name, $value)
    {
        if (!is_array($this->parameters))
        {
            $this->parameters = array();
        }

        $this->parameters[$name] = $value;
    }

    /**
     * Get single parameter from request
     * 
     * @access public
     * @param  string $name
     * @return string
     */
    public function getParameter($name)
    {
        if (isset($this->parameters[$name]))
        {
            if (is_array($this->parameters[$name]))
            {
                if (count($this->parameters[$name]) == 0)
                {
                    return false;
                }
            }

            if (empty($this->parameters[$name]))
            {
                return false;
            }

            return $this->parameters[$name];
        }

        return false;
    }

    /**
     * Check if single parameter is set
     * 
     * @access public
     * @param  string $name
     * @return boolean
     */
    public function isParameterSet($name)
    {
        if (isset($this->parameters[$name]))
        {
            return true;
        }

        return false;
    }
}