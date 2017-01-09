<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Entity\OperatingRoom;
use Symfony\Component\Yaml\Yaml;
/**
 * Class LoadOperatingRoomData
 * This class is used to pre-load Anesthetist data from Yaml/operating_rooms.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadOperatingRoomData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load OperatingRooms from Yaml/operating_rooms.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $operatingRoomsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/operating_rooms.yml'));
        foreach ($operatingRoomsData as $key => $operatingRoomData){
            $operatingRoom = new OperatingRoom();
            $operatingRoom->setName($operatingRoomData["name"]);
            $operatingRoom->setDescription($operatingRoomData["description"]);
            $operatingRoom->setHospital($this->getReference('hospital_one'));
            $manager->persist($operatingRoom);
            $this->addReference($key, $operatingRoom);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 12;
    }
}
