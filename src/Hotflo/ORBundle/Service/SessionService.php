<?php

namespace Hotflo\ORBundle\Service;

use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Entity\Session;
use Hotflo\ORBundle\Entity\Specialist;

/**
 * Class SessionService
 *
 * Service class to handle session management.
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class SessionService extends BaseService
{
    /**
     * Create new session.
     *
     * @param Session $session
     * @return bool
     */
    public function addNewSession(Session $session)
    {
        $specialistForSession = $session->getSpecialist();
        $anesthetistsForSession = $session->getAnesthetists();
        $canAddSpecialist = $this->capacityManagerService->canSessionAccommodateSpecialist($session, $specialistForSession);
        if (false === $canAddSpecialist){
            $this->messageType = self::MESSAGE_TYPE_FAILURE;
            $this->message = $this->getConfigMessage("session_cannot_add_specialist");

            return false;
        }

        /** @var Anesthetist $anesthetistForSession */
        foreach ($anesthetistsForSession as $anesthetistForSession) {
            $canAddAnesthetist = $this->capacityManagerService->canSessionAccommodateAnesthetist($session, $anesthetistForSession);
            if (false === $canAddAnesthetist){
                $this->messageType = self::MESSAGE_TYPE_FAILURE;
                $this->message = str_replace("{anesthetist}", $anesthetistForSession->getFirstName(), $this->getConfigMessage("session_cannot_add_anesthetist"));

                return false;
            }
        }

        $this->entityManager->persist($session);
        $this->entityManager->flush();
        $this->messageType = self::MESSAGE_TYPE_SUCCESS;
        $this->message = $this->getConfigMessage("session_added_successfully");

        return true;
    }

    /**
     * Get specialist's session detail for a given timeslot.
     *
     * @param Specialist $specialist
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array|null
     */
    public function getSpecialistSessionForTimeslot(Specialist $specialist, \DateTime $startTime, \DateTime $endTime)
    {
        $sessions = $this->entityManager
            ->getRepository('HotfloORBundle:Session')
            ->getSpecialistSessionForTimeslot($specialist, $startTime, $endTime);

        return $sessions;
    }
}