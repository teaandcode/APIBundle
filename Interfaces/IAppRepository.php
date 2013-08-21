<?php
/**
 * Tea and Code API Bundle IAppRepository Interface
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
 * This interface specifies the AppRepository entity methods
 *
 * @package TeaAndCode\APIBundle\Interfaces\IAppRepository
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
interface IAppRepository
{
    /**
     * Get App entity by app_id and app_domain
     *
     * @param string $app_id     The id of the app
     * @param string $app_domain The domain of the app
     *
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IApp
     */
    public function getByAppIdAndAppDomain($app_id, $app_domain);

    /**
     * Get App entity by app_id and app_secret
     *
     * @param string $app_id     The id of the app
     * @param string $app_secret The secret of the app
     *
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IApp
     */
    public function getByAppIdAndAppSecret($app_id, $app_secret);

    /**
     * Get App entity by hash id
     *
     * @param string $id The id of the hash
     *
     * @access public
     * @return TeaAndCode\APIBundle\Interfaces\IApp
     */
    public function getByHashId($id);
}