<?php

namespace Hotflo\ORBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Hotflo\ORBundle\Helper\MessageTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseService
 *
 * Base class for the service classes.
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
abstract class BaseService
{
    use MessageTrait;

    const MESSAGE_TYPE_SUCCESS = 'success_message';

    const MESSAGE_TYPE_FAILURE = 'failure_message';

    /**
     * @var CapacityManagerInterface
     */
    protected $capacityManagerService;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Services can return messages based on their operations.
     * @var string
     */
    protected $message;

    /**
     * Type of the message. This can hold MESSAGE_TYPE_SUCCESS or MESSAGE_TYPE_FAILURE
     *
     * @var string
     */
    protected $messageType;

    public function __construct(
        CapacityManagerInterface $capacityManagerService,
        EntityManagerInterface $entityManager,
        ContainerInterface $container
    )
    {
        $this->capacityManagerService = $capacityManagerService;
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return BaseService
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessageType()
    {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     * @return BaseService
     */
    public function setMessageType($messageType)
    {
        $this->messageType = $messageType;

        return $this;
    }
}