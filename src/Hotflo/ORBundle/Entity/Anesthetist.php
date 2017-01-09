<?php

namespace Hotflo\ORBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Anesthetist
 */
class Anesthetist
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var int
     */
    private $availabilityPerWeek;

    /**
     * @var Hospital
     */
    private $hospital;

    /**
     * @var Session[]
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Anesthetist
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Anesthetist
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Anesthetist
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Anesthetist
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set availabilityPerWeek
     *
     * @param integer $availabilityPerWeek
     *
     * @return Anesthetist
     */
    public function setAvailabilityPerWeek($availabilityPerWeek)
    {
        $this->availabilityPerWeek = $availabilityPerWeek;

        return $this;
    }

    /**
     * Get availabilityPerWeek
     *
     * @return int
     */
    public function getAvailabilityPerWeek()
    {
        return $this->availabilityPerWeek;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital $hospital
     * @return Anesthetist
     */
    public function setHospital($hospital)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * @return Session[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     *
     * @param Session $session
     *
     * @return Anesthetist
     */
    public function addSessions(Session $session)
    {
        $this->sessions->add($session);

        return $this;
    }
}

