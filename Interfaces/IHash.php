<?php
/**
 * Tea and Code API Bundle IHash Interface
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

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * This interface specifies the Hash entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IHash
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface IHash
{
    /**
     * Set id
     *
     * @access public
     * @return void
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
     * @param IApp $app Set IApp object as hash app
     *
     * @access public
     * @return void
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
     * @return void
     */
    public function setExpires();

    /**
     * Get expires
     *
     * @access public
     * @return DateTime
     */
    public function getExpires();
}