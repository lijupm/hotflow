<?php

namespace Hotflo\ORBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Hotflo\ORBundle\Entity\Hospital as Hospital;

/**
 * Class HospitalService
 *
 * @author <liju.p@comakeit.com>
 * @package Hotflo\ORBundle\Service
 */
class HospitalService extends BaseService
{
    /**
     * Get OperatingRooms of a hospital
     *
     * @param string $hospitalHandle
     * @return ArrayCollection
     */
    public function getOperatingRooms($hospitalHandle)
    {
        /** @var Hospital $hospital */
        $hospital = $this->entityManager->getRepository('HotfloORBundle:Hospital')->findOneBy(["handle" => $hospitalHandle]);
        $operatingRooms = $hospital->getOperatingRooms();

        return $operatingRooms;
    }

    /**
     * Returns currently configured hospital.
     *
     * @return Hospital
     */
    public function getCurrentHospital()
    {
        $hospitalHandle = $this->container->getParameter('hospital_handle');

        /** @var Hospital $hospital */
        $hospital = $this->entityManager
            ->getRepository('HotfloORBundle:Hospital')
            ->findOneBy(["handle" => $hospitalHandle]);

        return $hospital;
    }
}