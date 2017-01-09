<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Entity\Patient;
use Symfony\Component\Yaml\Yaml;
/**
 * Class LoadPatientData
 * This class is used to pre-load Anesthetist data from Yaml/patients.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadPatientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load Patient from Yaml/patients.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $patientsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/patients.yml'));
        foreach ($patientsData as $key => $patientData){
            $patient = new Patient();
            $patient->setFirstName($patientData["first_name"]);
            $patient->setLastName($patientData["last_name"]);
            $patient->setGender($patientData["gender"]);
            $patient->setDob(\DateTime::createFromFormat("d-m-Y", $patientData["dob"]));
            $manager->persist($patient);
            $this->addReference($key, $patient);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
