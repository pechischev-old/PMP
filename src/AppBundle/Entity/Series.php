<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="series")
 */
class Series
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $viewStatus;

    /**
     * @ORM\OneToMany(targetEntity="SerialData", mappedBy="series")
     */
    private $serial;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Series
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
     * Set status
     *
     * @param string $status
     *
     * @return Series
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set seasonCount
     *
     * @param integer $seasonCount
     *
     * @return Series
     */
    public function setSeasonCount($seasonCount)
    {
        $this->seasonCount = $seasonCount;

        return $this;
    }

    /**
     * Get seasonCount
     *
     * @return integer
     */
    public function getSeasonCount()
    {
        return $this->seasonCount;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->serial = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add serial
     *
     * @param \AppBundle\Entity\SerialData $serial
     *
     * @return Series
     */
    public function addSerial(\AppBundle\Entity\SerialData $serial)
    {
        $this->serial[] = $serial;

        return $this;
    }

    /**
     * Remove serial
     *
     * @param \AppBundle\Entity\SerialData $serial
     */
    public function removeSerial(\AppBundle\Entity\SerialData $serial)
    {
        $this->serial->removeElement($serial);
    }

    /**
     * Get serial
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set viewStatus
     *
     * @param boolean $viewStatus
     *
     * @return Series
     */
    public function setViewStatus($viewStatus)
    {
        $this->viewStatus = $viewStatus;

        return $this;
    }

    /**
     * Get viewStatus
     *
     * @return boolean
     */
    public function getViewStatus()
    {
        return $this->viewStatus;
    }
}
