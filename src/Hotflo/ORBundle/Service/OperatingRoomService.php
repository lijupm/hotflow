<?php

namespace Hotflo\ORBundle\Service;

use Hotflo\ORBundle\Entity\OperatingRoom;

/**
 * Class OperatingRoomService
 *
 * Service class to handle all operating room related tasks.
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class OperatingRoomService extends BaseService
{
    /**
     * @var HospitalService
     */
    private $hospitalService;

    /**
     * Inject dependency service
     *
     * @param HospitalService $hospitalService
     */
    public function setHospitalService(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    public function addNewOperatingRoom(OperatingRoom $operatingRoom)
    {
        $hospital = $this->hospitalService->getCurrentHospital();
        if ($this->capacityManagerService->hasReachedORLimit($hospital)){
            $this->messageType = self::MESSAGE_TYPE_FAILURE;
            $this->message = $this->getConfigMessage('OR_limit_reached');

            return false;
        }

        $operatingRoom->setHospital($hospital);
        $this->entityManager->persist($operatingRoom);
        $this->entityManager->flush();
        $this->messageType = self::MESSAGE_TYPE_SUCCESS;
        $this->message = $this->getConfigMessage('OR_added_successfully');

        return true;
    }

    /**
     * Get sessions of an operating room
     *
     * @param $operatingRoomId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSessions($operatingRoomId)
    {
        /** @var OperatingRoom $operatingRoom */
        $operatingRoom = $this->getOperatingRoomById($operatingRoomId);
        $sessions = $operatingRoom->getSessions();

        return $sessions;
    }

    public function getOperatingRoomById($operatingRoomId)
    {
        $operatingRoom = $this->entityManager->getRepository('HotfloORBundle:OperatingRoom')->find($operatingRoomId);

        return $operatingRoom;
    }
}