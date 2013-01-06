<?php
/**
 * Tea and Code API Bundle
 *
 * PHP version 5
 * 
 * @category Bundle
 * @package  TeaAndCodeAPIBundle
 * @version  1.0
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * TeaAndCode\APIBundle\TeaAndCodeAPIBundle
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage Bundle
 */
class TeaAndCodeAPIBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}