<?php
/**
 * Tea and Code API Bundle IRole Interface
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
 * TeaAndCode\APIBundle\Interfaces\IRole
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IRole
{
    /**
     * Get id
     * 
     * @access public
     * @return integer 
     */
    public function getId();

    /**
     * Set user
     * 
     * @access public
     * @param  Symfony\Component\Security\Core\User\AdvancedUserInterface $user
     */
    public function setUser(AdvancedUserInterface $user);

    /**
     * Get user
     * 
     * @access public
     * @return Symfony\Component\Security\Core\User\AdvancedUserInterface
     */
    public function getUser();

    /**
     * Set name
     * 
     * @access public
     * @param  string $name
     */
    public function setName($name);

    /**
     * Get name
     * 
     * @access public
     * @return string 
     */
    public function getName();

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