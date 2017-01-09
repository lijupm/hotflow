<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

use Hotflo\ORBundle\Entity\Hospital;
/**
 * Class LoadHospitalData
 * This class is used to pre-load hospital data from Yaml/hospitals.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadHospitalData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load users from Yaml/hospitals.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $hospitalsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/hospitals.yml'));
        foreach ($hospitalsData as $key => $hospitalData){
            $hospital = new Hospital();

            $hospital->setName($hospitalData['name']);
            $hospital->setHandle($hospitalData['handle']);
            $hospital->setDescription($hospitalData['description']);
            $hospital->setAddress($hospitalData['address']);
            $hospital->setOrMaxCapacity($hospitalData['or_max_capacity']);
            $hospital->setSpecialistsMaxCapacity($hospitalData['specialists_max_capacity']);
            $hospital->setAnesthetistMaxCapacity($hospitalData['anesthetist_max_capacity']);
            $hospital->setSpecialism($this->getReference('specialism_one'));
            $manager->persist($hospital);
            $this->addReference($key, $hospital);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
