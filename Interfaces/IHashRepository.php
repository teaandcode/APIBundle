<?php
/**
 * Tea and Code API Bundle IHashRepository Interface
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\Interfaces
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\Interfaces;

/**
 * This interface specifies the HashRepository entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IHashRepository
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface IHashRepository
{
    /**
     * Create Hash Entity
     *
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IHash
     */
    public static function create();

    /**
     * Clear expired Hash Entities
     *
     * @access public
     * @return void
     */
    public function removeExpired();
}