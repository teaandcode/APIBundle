<?php
/**
 * Tea and Code API Bundle Kernel Event Listener
 *
 * PHP version 5
 *
 * @package TeaAndCode\APIBundle\EventListener
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version GIT: $Id$
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */

namespace TeaAndCode\APIBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * This class listens for Doctrine Persist events
 *
 * @package TeaAndCode\APIBundle\EventListener\PersistListener
 * @author  Dave Nash <dave.nash@teaandcode.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @version Release: @package_version@
 * @link    http://www.teaandcode.com/symfony-2/api-bundle APIBundle Docs
 */
class PersistListener
{
    /**
     * Stores container object
     *
     * @access protected
     * @var    Symfony\Component\DependencyInjection\Container $container
     */
    protected $container;

    /**
     * Stores doctrine object
     *
     * @access protected
     * @var    Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     */
    protected $doctrine;

    /**
     * Sets-up environment with services arguments
     *
     * @param Doctrine  $doctrine  Doctrine object
     * @param Container $container Container object
     *
     * @access public
     * @return TeaAndCode\APIBundle\EventListener\PersistListener
     */
    public function __construct(Doctrine $doctrine, Container $container)
    {
        $this->container = $container;
        $this->doctrine  = $doctrine;
    }

    /**
     * Checks for expired hashes and tokens and removes them
     *
     * @param LifecycleEventArgs $args Event arguments
     *
     * @access public
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $hash = $this
            ->doctrine
            ->getRepository(
                $this->container->getParameter('api_hash_repository')
            );
        $token = $this
            ->doctrine
            ->getRepository(
                $this->container->getParameter('api_token_repository')
            );

        switch (get_class($entity))
        {
            case get_class($hash->create()):
                $hash->removeExpired();
                break;

            case get_class($token->create()):
                $token->removeExpired();
                break;
        }
    }
}