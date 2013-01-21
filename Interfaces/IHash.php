<?php
/**
 * Tea and Code API Bundle IHash Interface
 *
 * PHP version 5
 * 
 * @category Interface
 * @package  TeaAndCodeAPIBundle
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\Interfaces;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * TeaAndCode\APIBundle\Interfaces\IHash
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IHash
{
    /**
     * Set id
     * 
     * @access public
     */
    public function setId();

    /**
     * Get id
     * 
     * @access public
     * @return string 
     */
    public function getId();

    /**
     * Set app
     * 
     * @access public
     * @param  TeaAndCode\APIBundle\Interfaces\IApp $app
     */
    public function setApp(IApp $app);

    /**
     * Get app
     * 
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IApp
     */
    public function getApp();

    /**
     * Set expires
     * 
     * @access public
     */
    public function setExpires();

    /**
     * Get expires
     * 
     * @access public
     * @return DateTime 
     */
    public function getExpires();

    /**
     * Set created
     * 
     * @access public
     */
    public function setCreated();

    /**
     * Get created
     * 
     * @access public
     * @return DateTime 
     */
    public function getCreated();

    /**
     * Set updated
     * 
     * @access public
     */
    public function setUpdated();

    /**
     * Get updated
     * 
     * @access public
     * @return DateTime 
     */
    public function getUpdated();
}