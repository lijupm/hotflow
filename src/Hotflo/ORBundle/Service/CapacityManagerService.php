<?php

namespace Hotflo\ORBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Entity\Hospital;
use Hotflo\ORBundle\Entity\Session;
use Hotflo\ORBundle\Entity\Specialist;

/**
 * Class CapacityManagerService
 *
 * This class would handle all the capacity related operations - including OR limit, Specialist limit,
 * Anesthetist limit etc
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class CapacityManagerService implements CapacityManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Check whether the given hospital has reached its max OR capacity
     *
     * @param Hospital $hospital
     *
     * @return bool
     */
    public function hasReachedORLimit(Hospital $hospital)
    {
        $hospitalORMaxCapacity = $hospital->getOrMaxCapacity();

        /** @var ArrayCollection $operatingRooms */
        $operatingRooms = $hospital->getOperatingRooms();

        if ($hospitalORMaxCapacity <= $operatingRooms->count()){
            return true;
        }

        return false;
    }

    /**
     * Check whether the given hospital has reached its max Specialist capacity
     *
     * @param Hospital $hospital
     * @return bool
     */
    public function hasReachedSpecialistLimit(Hospital $hospital)
    {
        $hospitalSpecialistMaxCapacity = $hospital->getSpecialistsMaxCapacity();

        /** @var ArrayCollection $specialists */
        $specialists = $hospital->getSpecialists();

        if ($hospitalSpecialistMaxCapacity <= $specialists->count()){
            return true;
        }

        return false;
    }

    /**
     * Check whether the given hospital has reached its max Anesthetist capacity
     *
     * @param Hospital $hospital
     * @return bool
     */
    public function hasReachedAnesthetistsLimit(Hospital $hospital)
    {
        $hospitalAnesthetistMaxCapacity = $hospital->getAnesthetistMaxCapacity();

        /** @var ArrayCollection $anesthetists */
        $anesthetists = $hospital->getAnesthetists();

        if ($hospitalAnesthetistMaxCapacity <= $anesthetists->count()){
            return true;
        }

        return false;
    }

    /**
     * A Specialist has limit to his working hours per week, so need to check whether he can be added to a session.
     *
     * @param Session $session
     * @param Specialist $specialist
     * @return bool
     */
    public function canSessionAccommodateSpecialist(Session $session, Specialist $specialist)
    {
        return $this->canSessionAccommodateStaff($session, $specialist);
    }

    /**
     * An Anesthetist has limit to his working hours, so need to check whether he can be added to a session.
     *
     * @param Session $session
     * @param Anesthetist $anesthetist
     * @return bool
     */
    public function canSessionAccommodateAnesthetist(Session $session, Anesthetist $anesthetist)
    {
        return $this->canSessionAccommodateStaff($session, $anesthetist);
    }

    /**
     * Check whether a given specialist or anesthetist can be accomodated in a session.
     *
     * @param Session $session
     * @param Specialist|Anesthetist $staff
     * @return bool
     */
    private function canSessionAccommodateStaff(Session $session, $staff)
    {
        $totalMinutesCommittedIntheWeek = 0;

        /** @var \DateTime $startTime */
        $startTime = $session->getStartTime();
        $endTime = $session->getEndTime();
        $monday = $startTime->modify("Monday this week");
        $friday = $endTime->modify("Friday this week");

        if ($staff instanceof Specialist) {
            $committedSessions = $this->entityManager
                ->getRepository("HotfloORBundle:Specialist")
                ->getSpecialistSessionsBetweenDates($staff, $monday, $friday);
        } else if ($staff instanceof Anesthetist){
            $committedSessions = $this->entityManager
                ->getRepository("HotfloORBundle:Anesthetist")
                ->getAnesthetistSessionForTimeslot($staff, $monday, $friday);
        }

        /** @var Session $session */
        foreach ($committedSessions as $committedSession){
            $sessionStartTime = $committedSession->getStartTime();
            $sessionEndTime = $committedSession->getEndTime();
            $diff = $sessionEndTime->diff($sessionStartTime);

            $totalMinutesCommittedIntheWeek += ($diff->h * 60) + $diff->i;
        }
        $sessionLengthDiff = $session->getEndTime()->diff($session->getStartTime());
        $sessionLengthInMinutes = ($sessionLengthDiff->h * 60) + $sessionLengthDiff->i;
        $specialistMaxMinutesPerWeek = $staff->getAvailabilityPerWeek() * 60;
        if (($totalMinutesCommittedIntheWeek + $sessionLengthInMinutes) < $specialistMaxMinutesPerWeek)
        {
            return true;
        }

        return false;
    }

}