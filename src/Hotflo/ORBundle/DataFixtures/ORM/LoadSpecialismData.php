<?php

namespace Hotflo\ORBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hotflo\ORBundle\Entity\Specialism;
use Symfony\Component\Yaml\Yaml;

/**
 * Class LoadSpecialismData
 * This class is used to pre-load specialism data from Yaml/specialisms.yml file.
 *
 * @package Hotflo\ORBundle\DataFixtures\ORM
 */
class LoadSpecialismData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load specialisms from Yaml/specialisms.yml file
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $specialismsData = Yaml::parse(file_get_contents(__DIR__ . '/Yaml/specialisms.yml'));
        foreach ($specialismsData as $key => $specialismData){
            $specialism = new Specialism();
            $specialism->setName($specialismData["name"]);
            $specialism->setDescription($specialismData["description"]);
            $manager->persist($specialism);
            $this->addReference($key, $specialism);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
