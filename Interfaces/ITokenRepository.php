<?php
/**
 * Tea and Code API Bundle ITokenRepository Interface
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
 * TeaAndCode\APIBundle\Interfaces\ITokenRepository
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface ITokenRepository
{
    /**
     * Create Token Entity
     * 
     * @access public
     * @param  array $fields
     * @param  Doctrine\ORM\EntityManager $manager
     * @return TeaAndCode\APIBundle\Interfaces\IToken
     */
    public static function create(array $fields = array(), $manager = null);

    /**
     * Clear expired Token Entities
     * 
     * @access public
     */
    public function removeExpired();
}