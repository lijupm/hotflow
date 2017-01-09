<?php

namespace Hotflo\ORBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OperatingRoom
 */
class OperatingRoom
{
    /**
     * @var int
     */
    private $id;


    /**
     * @var Hospital
     */
    private $hospital;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var ArrayCollection
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
     * Set name
     *
     * @param string $name
     *
     * @return OperatingRoom
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
     * @return OperatingRoom
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
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital $hospital
     *
     * @return OperatingRoom
     */
    public function setHospital(Hospital $hospital)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     *
     * @param Session $session
     *
     * @return OperatingRoom
     */
    public function setSession(Session $session)
    {
        $this->sessions->add($session);

        return $this;
    }


}

