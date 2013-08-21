<?php
/**
 * Tea and Code API Bundle
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\Object
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This class kicks off use for the bundle
 *
 * @package TeaAndCode\APIBundle\TeaAndCodeAPIBundle
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class TeaAndCodeAPIBundle extends Bundle
{
    /**
     * Builds the bundle
     *
     * @param ContainerBuilder $container Symfony Container object
     *
     * @access public
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}