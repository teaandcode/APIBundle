<?php
/**
 * Tea and Code API Bundle IToken Interface
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
 * This interface specifies the Token entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IToken
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface IToken
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
     * @param IApp $app Set IApp object as token app
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
     * Set user
     *
     * @param IUser $user Set IUser object as token user
     *
     * @access public
     * @return void
     */
    public function setUser(IUser $user);

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