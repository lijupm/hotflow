<?php

namespace Hotflo\ORBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Session
 */
class Session
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
    private $description;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var OperatingRoom
     */
    private $operatingRoom;

    /**
     * @var Specialist
     */
    private $specialist;

    /**
     * @var Patient
     */
    private $patient;

    /**
     * @var ArrayCollection
     */
    private $anesthetists;

    public function __construct()
    {
        $this->anesthetists = new ArrayCollection();
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
     * @return Session
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
     * Set description
     *
     * @param string $description
     *
     * @return Session
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
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Session
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Session
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return OperatingRoom
     */
    public function getOperatingRoom()
    {
        return $this->operatingRoom;
    }

    /**
     * @param OperatingRoom $operatingRoom
     * @return Session
     */
    public function setOperatingRoom(OperatingRoom $operatingRoom)
    {
        $this->operatingRoom = $operatingRoom;

        return $this;
    }

    /**
     * @return Specialist
     */
    public function getSpecialist()
    {
        return $this->specialist;
    }

    /**
     * @param Specialist $specialist
     * @return Session
     */
    public function setSpecialist(Specialist $specialist)
    {
        $this->specialist = $specialist;

        return $this;
    }


    /**
     * @return Session[]
     */
    public function getAnesthetists()
    {
        return $this->anesthetists;
    }

    /**
     * @param Anesthetist $anesthetist
     *
     * @return Session
     *
     */
    public function addAnesthetist(Anesthetist $anesthetist)
    {
        $this->anesthetists->add($anesthetist);

        return $this;
    }

    /**
     * @return Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param Patient $patient
     * @return Session
     */
    public function setPatient(Patient $patient)
    {
        $this->patient = $patient;

        return $this;
    }
}

