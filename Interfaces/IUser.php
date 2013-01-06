<?php
/**
 * Tea and Code API Bundle IUser Interface
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
 * TeaAndCode\APIBundle\Interface\IUser
 * 
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IUser extends AdvancedUserInterface, \Serializable
{
    /**
     * Get id
     * 
     * @access public
     * @return integer 
     */
    public function getId();

    /**
     * Set email
     * 
     * @access public
     * @param  string $email
     */
    public function setEmail($email);

    /**
     * Get email
     * 
     * @access public
     * @return string 
     */
    public function getEmail();

    /**
     * Set password
     * 
     * @access public
     * @param  string $password
     */
    public function setPassword($password);

    /**
     * Update lastLogin
     * 
     * @access public
     */
    public function updateLastLogin();

    /**
     * Get lastLogin
     * 
     * @access public
     * @return DateTime
     */
    public function getLastLogin();

    /**
     * Update numberOfLogins
     * 
     * @access public
     */
    public function updateNumberOfLogins();

    /**
     * Get numberOfLogins
     * 
     * @access public
     * @return integer
     */
    public function getNumberOfLogins();

    /**
     * Set enabled
     * 
     * @access public
     * @param  boolean $enabled
     */
    public function setEnabled($enabled);

    /**
     * Add role
     *
     * @access public
     * @param  TheJobPost\APIBundle\Entity\Role $role
     */
    public function addRole(IRole $role);

    /**
     * Add token
     *
     * @access public
     * @param  TheJobPost\APIBundle\Entity\Token $token
     */
    public function addToken(IToken $token);

    /**
     * Get tokens
     *
     * @access public
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getTokens();

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