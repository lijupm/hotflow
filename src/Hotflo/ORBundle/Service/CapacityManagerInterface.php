<?php

namespace Hotflo\ORBundle\Service;

use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Entity\Hospital;
use Hotflo\ORBundle\Entity\Session;
use Hotflo\ORBundle\Entity\Specialist;

/**
 * Interface CapacityManagerInterface
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
interface CapacityManagerInterface
{
    /**
     * Check whether the given hospital has reached its max OR capacity
     *
     * @param Hospital $hospital
     * @return bool
     */
    public function hasReachedORLimit(Hospital $hospital);

    /**
     * Check whether the given hospital has reached its max Specialist capacity
     *
     * @param Hospital $hospital
     * @return bool
     */
    public function hasReachedSpecialistLimit(Hospital $hospital);

    /**
     * Check whether the given hospital has reached its max Anesthetist capacity
     *
     * @param Hospital $hospital
     * @return bool
     */
    public function hasReachedAnesthetistsLimit(Hospital $hospital);

    /**
     * A Specialist has limit to his working hours, so need to check whether he can be added to a session.
     *
     * @param Session $session
     * @param Specialist $specialist
     * @return bool
     */
    public function canSessionAccommodateSpecialist(Session $session, Specialist $specialist);

    /**
     * An Anesthetist has limit to his working hours, so need to check whether he can be added to a session.
     *
     * @param Session $session
     * @param Anesthetist $anesthetist
     * @return bool
     */
    public function canSessionAccommodateAnesthetist(Session $session, Anesthetist $anesthetist);
}