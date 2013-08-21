<?php
/**
 * Tea and Code API Bundle IGrant Interface
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
 * This interface specifies the Grant entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IGrant
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface IGrant
{
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
     * @param IApp $app Set IApp object as grant app
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
     * @param IUser $user Set IUser object as grant user
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
     * Set permissions
     *
     * @param array $permissions Set permissions array as grant permissions
     *
     * @access public
     * @return void
     */
    public function setPermissions(array $permissions);

    /**
     * Get permissions
     *
     * @access public
     * @return array
     */
    public function getPermissions();
}