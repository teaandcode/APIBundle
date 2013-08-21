<?php
/**
 * Tea and Code API Bundle ITokenRepository Interface
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
 * This interface specifies the TokenRepository entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\ITokenRepository
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface ITokenRepository
{
    /**
     * Create Token Entity
     *
     * @param array         $fields  Array of fields to be set
     * @param EntityManager $manager Symfony's entity manager
     *
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IToken
     */
    public static function create(array $fields = array(), $manager = null);

    /**
     * Clear expired Token Entities
     *
     * @access public
     * @return void
     */
    public function removeExpired();
}