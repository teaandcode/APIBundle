<?php
/**
 * Tea and Code API Bundle Persist Event Listener
 *
 * PHP version 5
 * 
 * @category EventListener
 * @package  TeaAndCodeAPIBundle
 * @author   Dave Nash <dave.nash@teaandcode.com>
 * @license  Apache License, Version 2.0
 * @link     http://www.teaandcode.com
 */

namespace TeaAndCode\APIBundle\EventListener;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * TeaAndCode\APIBundle\EventListener\PersistListener
 *
 * @package    TeaAndCodeAPIBundle
 * @subpackage EventListener
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
     * @access public
     * @return TeaAndCode\APIBundle\EventListener\PersistListener
     */
	public function __construct(Doctrine $doctrine, Container $container)
	{
	    $this->container = $container;
		$this->doctrine = $doctrine;
	}

    /**
     * Checks for expired hashes and tokens and removes them
     * 
     * @access public
     * @param  Doctrine\ORM\Event\LifecycleEventArgs $event
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