<?php

namespace Hotflo\ORBundle\Service;

use Hotflo\ORBundle\Entity\Anesthetist;

/**
 * Class AnesthetistService
 *
 * Service class to handle anesthetists related operations
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class AnesthetistService extends BaseService
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
     * Add new anesthetist
     *
     * @param Anesthetist $anesthetist
     * @return bool
     */
    public function addNewAnesthetist(Anesthetist $anesthetist)
    {
        $hospital = $this->hospitalService->getCurrentHospital();
        if ($this->capacityManagerService->hasReachedAnesthetistsLimit($hospital)){
            $this->messageType = self::MESSAGE_TYPE_FAILURE;
            $this->message = $this->getConfigMessage("anesthetists_limit_reached");

            return false;
        }

        $anesthetist->setHospital($hospital);
        $this->entityManager->persist($anesthetist);
        $this->entityManager->flush();

        $this->messageType = self::MESSAGE_TYPE_SUCCESS;
        $this->message = $this->getConfigMessage("anesthetist_added_successfully");

        return true;
    }

    /**
     * Get sessions of a anesthetist
     *
     * @param int $anesthetistId
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSessions($anesthetistId)
    {
        /** @var Anesthetist $anesthetist */
        $anesthetist = $this->getSpecialistById($anesthetistId);
        $sessions = $anesthetist->getSessions();

        return $sessions;
    }

    /**
     * Get anesthetist by id
     *
     * @param int $anesthetistId
     * @return \Hotflo\ORBundle\Entity\Anesthetist
     */
    public function getAnesthetistById($anesthetistId)
    {
        $specialist = $this->entityManager
            ->getRepository('HotfloORBundle:Anesthetist')
            ->find($anesthetistId);

        return $specialist;
    }
}