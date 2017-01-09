<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Specialist;
use Symfony\Component\Yaml\Yaml;
/**
 * Class LoadSpecialistData
 * This class is used to pre-load Specialist data from Yaml/specialists.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadSpecialistData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load specialists from Yaml/specialists.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $specialistsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/specialists.yml'));
        foreach ($specialistsData as $key => $specialistData){
            $specialist = new Specialist();
            $specialist->setFirstName($specialistData["first_name"]);
            $specialist->setLastName($specialistData["last_name"]);
            $specialist->setGender($specialistData["gender"]);
            $specialist->setDob(\DateTime::createFromFormat("d-m-Y", $specialistData["dob"]));
            $specialist->setAvailabilityPerWeek($specialistData["availability_per_week"]);
            $specialist->setSpecialism($this->getReference('specialism_one'));
            $specialist->setHospital($this->getReference('hospital_one'));
            $manager->persist($specialist);
            $this->addReference($key, $specialist);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}
