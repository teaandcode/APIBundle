<?php
/**
 * Tea and Code API Bundle IToken Interface
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
 * TeaAndCode\APIBundle\Interfaces\IToken
 * 
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IToken
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
     * Set user
     * 
     * @access public
     * @param  TeaAndCode\APIBundle\Interfaces\IUser $user
     */
    public function setUser(AdvancedUserInterface $user);

    /**
     * Get user
     * 
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IUser
     */
    public function getUser();

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