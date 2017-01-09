<?php

namespace Hotflo\ORBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Specialism
 */
class Specialism
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
     * @var ArrayCollection
     */
    private $hospitals;

    public function __construct()
    {
        $this->hospitals = new ArrayCollection();
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
     * @return Specialism
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
     * @return Specialism
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
     * @return ArrayCollection
     */
    public function getHospitals()
    {
        return $this->hospitals;
    }

    /**
     * Set hospital
     *
     * @param $hospital
     * @return Specialism
     */
    public function setHospital($hospital)
    {
        $this->hospitals->add($hospital);

        return $this;
    }


}

