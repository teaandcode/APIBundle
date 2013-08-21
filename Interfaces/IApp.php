<?php
/**
 * Tea and Code API Bundle IApp Interface
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
 * This interface specifies the App entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IApp
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
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
     * @param string $name Set string value as app name
     *
     * @access public
     * @return void
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
     * @param string $appId Set string value as app id
     *
     * @access public
     * @return void
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
     * Set appDomain
     *
     * @param string $appDomain Set string value as app domain
     *
     * @access public
     * @return void
     */
    public function setAppDomain($appDomain);

    /**
     * Get appDomain
     *
     * @access public
     * @return string
     */
    public function getAppDomain();

    /**
     * Set appSecret
     *
     * @param string $appSecret Set string value as app secret
     *
     * @access public
     * @return void
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
     * Set trusted
     *
     * @param bool $trusted Set boolean value to say whether app is trusted
     *
     * @access public
     * @return void
     */
    public function setTrusted($trusted);

    /**
     * Get trusted
     *
     * @access public
     * @return bool
     */
    public function getTrusted();

    /**
     * Add admin
     *
     * @param IUser $admin Add IUser object as app admin
     *
     * @access public
     * @return void
     */
    public function addAdmin(IUser $admin);

    /**
     * Remove admin
     *
     * @param IUser $admin Remove IUser object as app admin
     *
     * @access public
     * @return void
     */
    public function removeAdmin(IUser $admin);

    /**
     * Get admins
     *
     * @access public
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getAdmins();

    /**
     * Add token
     *
     * @param IToken $token Add IToken object as app token
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