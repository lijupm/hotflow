<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Session;
use Symfony\Component\Yaml\Yaml;
/**
 * Class SessionData
 * This class is used to pre-load Anesthetist data from Yaml/sessions.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadSessionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load Sessions from Yaml/sessions.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $sessionsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/sessions.yml'));
        foreach ($sessionsData as $key => $sessionData){
            $session = new Session();
            $session->setName($sessionData["name"]);
            $session->setDescription($sessionData["description"]);
            $session->setStartTime(\DateTime::createFromFormat("d-m-Y H:i", $sessionData["start_time"]));
            $session->setEndTime(\DateTime::createFromFormat("d-m-Y H:i", $sessionData["end_time"]));
            $session->setOperatingRoom($this->getReference($sessionData["operating_room"]));
            $session->setSpecialist($this->getReference($sessionData["specialist"]));
            foreach ($sessionData["anesthetists"] as $anesthetist){
                $session->addAnesthetist($this->getReference($anesthetist));
            }
            $session->setPatient($this->getReference($sessionData["patient"]));
            $manager->persist($session);
            $this->addReference($key, $session);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 14;
    }
}
