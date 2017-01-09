<?php

namespace Hotflo\ORBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hospital
 */
class Hospital
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $handle;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $orMaxCapacity;

    /**
     * @var int
     */
    private $specialistsMaxCapacity;

    /**
     * @var int
     */
    private $anesthetistMaxCapacity;

    /**
     * @var ArrayCollection
     */
    private $specialisms;

    /**
     * @var ArrayCollection
     */
    private $operatingRooms;

    /**
     * @var ArrayCollection
     */
    private $specialists;

    /**
     * @var ArrayCollection
     */
    private $anesthetists;

    public function __construct()
    {
        $this->operatingRooms = new ArrayCollection();
        $this->specialists = new ArrayCollection();
        $this->anesthetists = new ArrayCollection();
        $this->specialisms = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Hospital
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param string $handle
     * @return Hospital
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Hospital
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Hospital
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set orMaxCapacity
     *
     * @param integer $orMaxCapacity
     *
     * @return Hospital
     */
    public function setOrMaxCapacity($orMaxCapacity)
    {
        $this->orMaxCapacity = $orMaxCapacity;

        return $this;
    }

    /**
     * Get orMaxCapacity
     *
     * @return int
     */
    public function getOrMaxCapacity()
    {
        return $this->orMaxCapacity;
    }

    /**
     * Set specialistsMaxCapacity
     *
     * @param integer $specialistsMaxCapacity
     *
     * @return Hospital
     */
    public function setSpecialistsMaxCapacity($specialistsMaxCapacity)
    {
        $this->specialistsMaxCapacity = $specialistsMaxCapacity;

        return $this;
    }

    /**
     * Get specialistsMaxCapacity
     *
     * @return int
     */
    public function getSpecialistsMaxCapacity()
    {
        return $this->specialistsMaxCapacity;
    }

    /**
     * Set anesthetistMaxCapacity
     *
     * @param integer $anesthetistMaxCapacity
     *
     * @return Hospital
     */
    public function setAnesthetistMaxCapacity($anesthetistMaxCapacity)
    {
        $this->anesthetistMaxCapacity = $anesthetistMaxCapacity;

        return $this;
    }

    /**
     * Get anesthetistMaxCapacity
     *
     * @return int
     */
    public function getAnesthetistMaxCapacity()
    {
        return $this->anesthetistMaxCapacity;
    }

    /**
     * @return ArrayCollection
     */
    public function getOperatingRooms()
    {
        return $this->operatingRooms;
    }

    /**
     * Add operating room
     *
     * @param OperatingRoom $operatingRoom
     *
     * @return Hospital
     */
    public function addOperatingRooms(OperatingRoom $operatingRoom)
    {
        $this->operatingRooms->add($operatingRoom);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSpecialists()
    {
        return $this->specialists;
    }

    /**
     * Add specialist
     *
     * @param Specialist $specialist
     *
     * @return Hospital
     */
    public function addSpecialist(Specialist $specialist)
    {
        $this->specialists->add($specialist);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnesthetists()
    {
        return $this->anesthetists;
    }

    /**
     * Add anesthetist
     *
     * @param Anesthetist $anesthetist
     *
     * @return Hospital
     */
    public function addAnesthetist(Anesthetist $anesthetist)
    {
        $this->anesthetists->add($anesthetist);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSpecialisms()
    {
        return $this->specialisms;
    }

    /**
     * Set specialism
     *
     * @param $specialism
     * @return Hospital
     */
    public function setSpecialism(Specialism $specialism)
    {
        $specialism->setHospital($this);

        $this->specialisms->add($specialism);

        return $this;
    }


}

