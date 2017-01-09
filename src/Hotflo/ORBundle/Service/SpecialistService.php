<?php

namespace Hotflo\ORBundle\Service;

use Hotflo\ORBundle\Entity\Specialist;

/**
 * Class SpecialistService
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class SpecialistService extends BaseService
{
    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * @var HospitalService
     */
    private $hospitalService;

    /**
     * Inject dependency services
     *
     * @param SessionService $sessionService
     * @param HospitalService $hospitalService
     */
    public function setServices(SessionService $sessionService, HospitalService $hospitalService)
    {
        $this->sessionService = $sessionService;
        $this->hospitalService = $hospitalService;
    }

    /**
     * Add new specialist
     *
     * @param Specialist $specialist
     * @return bool
     */
    public function addNewSpecialist(Specialist $specialist)
    {
        $hospital = $this->hospitalService->getCurrentHospital();
        if ($this->capacityManagerService->hasReachedSpecialistLimit($hospital)){
            $this->messageType = self::MESSAGE_TYPE_FAILURE;
            $this->message = $this->getConfigMessage("specialist_limit_reached");

            return false;
        }

        $specialist->setHospital($hospital);
        $this->entityManager->persist($specialist);
        $this->entityManager->flush();

        $this->messageType = self::MESSAGE_TYPE_SUCCESS;
        $this->message = $this->getConfigMessage("specialist_added_successfully");

        return true;
    }

    /**
     * Get sessions of a specialist
     *
     * @param $specialistId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSessions($specialistId)
    {
        /** @var Specialist $specialist */
        $specialist = $this->getSpecialistById($specialistId);
        $sessions = $specialist->getSessions();

        return $sessions;
    }

    /**
     * Get specialist By id
     *
     * @param $specialistId
     * @return \Hotflo\ORBundle\Entity\Specialist
     */
    public function getSpecialistById($specialistId)
    {
        $specialist = $this->entityManager
            ->getRepository('HotfloORBundle:Specialist')
            ->find($specialistId);

        return $specialist;
    }

    /**
     * Check a specialist's availability in a given timeslot.
     * If available, returns true, otherwise, return the session detail.
     *
     * @param Specialist $specialist
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array|bool|null
     */
    public function checkAvailabilityInTimeslot(Specialist $specialist, \DateTime $startTime, \DateTime $endTime)
    {
        $sessions = $this->sessionService->getSpecialistSessionForTimeslot($specialist, $startTime, $endTime);

        if (empty($sessions)){
            return true;
        }

        return $sessions;
    }
}