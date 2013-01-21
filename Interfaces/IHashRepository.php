<?php
/**
 * Tea and Code API Bundle IHashRepository Interface
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
 * TeaAndCode\APIBundle\Interfaces\IHashRepository
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Interface
 */
interface IHashRepository
{
    /**
     * Create Hash Entity
     * 
     * @access public
     * @param  array $fields
     * @param  Doctrine\ORM\EntityManager $manager
     * @return TeaAndCode\APIBundle\Interfaces\IHash
     */
    public static function create(array $fields = array(), $manager = null);

    /**
     * Get Hash Entity by hash id and app domain
     * 
     * @access public
     * @param  integer $id
     * @param  string $domain
     * @return TeaAndCode\APIBundle\Interfaces\IHash
     */
    public function getByIdAndAppDomain($id, $domain);

    /**
     * Clear expired Hash Entities
     * 
     * @access public
     */
    public function removeExpired();
}