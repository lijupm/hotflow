<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Anesthetist;
use Symfony\Component\Yaml\Yaml;
/**
 * Class LoadAnesthetistData
 * This class is used to pre-load Anesthetist data from Yaml/anesthetists.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadAnesthetistData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load Anesthetist from Yaml/anesthetists.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $anesthetistsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/anesthetists.yml'));
        foreach ($anesthetistsData as $key => $anesthetistData){
            $anesthetist = new Anesthetist();
            $anesthetist->setFirstName($anesthetistData["first_name"]);
            $anesthetist->setLastName($anesthetistData["last_name"]);
            $anesthetist->setGender($anesthetistData["gender"]);
            $anesthetist->setDob(\DateTime::createFromFormat("d-m-Y", $anesthetistData["dob"]));
            $anesthetist->setAvailabilityPerWeek($anesthetistData["availability_per_week"]);
            $anesthetist->setHospital($this->getReference('hospital_one'));
            $manager->persist($anesthetist);
            $this->addReference($key, $anesthetist);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 8;
    }
}
