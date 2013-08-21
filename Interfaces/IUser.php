<?php
/**
 * Tea and Code API Bundle IUser Interface
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
 * This interface specifies the User entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IUser
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
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
     * @param string $email Set string value as user e-mail
     *
     * @access public
     * @return void
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
     * @param string $password Set string value as user password
     *
     * @access public
     * @return void
     */
    public function setPassword($password);

    /**
     * Update lastLogin
     *
     * @access public
     * @return void
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
     * @return void
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
     * @param boolean $enabled Set boolean value as user enabled
     *
     * @access public
     * @return void
     */
    public function setEnabled($enabled);

    /**
     * Add role
     *
     * @param string $role Add string value as user role
     *
     * @access public
     * @return void
     */
    public function addRole($role);

    /**
     * Remove role
     *
     * @param string $role Remove string value as user role
     *
     * @access public
     * @return void
     */
    public function removeRole($role);

    /**
     * Add adminApp
     *
     * @param IApp $app Add IApp object as user app for administration
     *
     * @access public
     * @return void
     */
    public function addAdminApp(IApp $app);

    /**
     * Remove adminApp
     *
     * @param IApp $app Remove IApp object as user app for administration
     *
     * @access public
     * @return void
     */
    public function removeAdminApp(IApp $app);

    /**
     * Get adminApps
     *
     * @param boolean $deleted Whether apps for administration that are marked
     *                         as deleted are returned
     *
     * @access public
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getAdminApps($deleted);

    /**
     * Add token
     *
     * @param IToken $token Add IToken object as user token
     *
     * @access public
     * @return void
     */
    public function addToken(IToken $token);

    /**
     * Get tokens
     *
     * @access public
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getTokens();
}