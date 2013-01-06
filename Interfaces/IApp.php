<?php
/**
 * Tea and Code API Bundle IApp Interface
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

/**
 * TeaAndCode\APIBundle\Interfaces\IApp
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IApp
{
    /**
     * Get id
     * 
     * @access public
     * @return integer 
     */
    public function getId();

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
     * Set appId
     * 
     * @access public
     */
    public function setAppId($appId);

    /**
     * Get appId
     * 
     * @access public
     * @return string 
     */
    public function getAppId();

    /**
     * Set appSecret
     * 
     * @access public
     */
    public function setAppSecret($appSecret);

    /**
     * Get appSecret
     * 
     * @access public
     * @return string 
     */
    public function getAppSecret();

    /**
     * Set domain
     * 
     * @access public
     * @param  string $domain
     */
    public function setDomain($domain);

    /**
     * Get domain
     * 
     * @access public
     * @return string 
     */
    public function getDomain();

    /**
     * Add hash
     * 
     * @access public
     * @param  TeaAndCode\APIBundle\Interfaces\IHash $hash
     */
    public function addHash(IHash $hash);

    /**
     * Get hashes
     * 
     * @access public
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getHashes();

    /**
     * Add token
     * 
     * @access public
     * @param  TeaAndCode\APIBundle\Interfaces\IToken $token
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