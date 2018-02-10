<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="serialData")
 * @UniqueEntity(fields="title", message="Title name is already exist")
 */
class SerialData
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256, unique=true)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    /**
     * @ORM\Column(type="integer", length=4)
     */
    private $year;

    /**
     * @ORM\Column(type="text", length=4294967295, nullable=true)
     */
    private $capture;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     */
    private $endYear;

    /**
     * @ORM\OneToMany(targetEntity="Season", mappedBy="serialData")
     */
    private $season;

    /**
     * @ORM\Column(type="string")
     */
    private $genries;

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
     * Set title
     *
     * @param string $title
     *
     * @return SerialData
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return SerialData
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return SerialData
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
     * Set genries
     *
     * @param array $genries
     *
     * @return SerialData
     */
    public function setGenries($genries)
    {
        $this->genries = $genries;

        return $this;
    }

    /**
     * Get genries
     *
     * @return array
     */
    public function getGenries()
    {
        return $this->genries;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->series = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return SerialData
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set endYear
     *
     * @param integer $endYear
     *
     * @return SerialData
     */
    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;

        return $this;
    }

    /**
     * Get endYear
     *
     * @return integer
     */
    public function getEndYear()
    {
        return $this->endYear;
    }

    /**
     * Add season
     *
     * @param \AppBundle\Entity\Season $season
     *
     * @return SerialData
     */
    public function addSeason(\AppBundle\Entity\Season $season)
    {
        $this->season[] = $season;

        return $this;
    }

    /**
     * Remove season
     *
     * @param \AppBundle\Entity\Season $season
     */
    public function removeSeason(\AppBundle\Entity\Season $season)
    {
        $this->season->removeElement($season);
    }

    /**
     * Get season
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set capture
     *
     * @param string $capture
     *
     * @return SerialData
     */
    public function setCapture($capture)
    {
        $this->capture = $capture;

        return $this;
    }

    /**
     * Get capture
     *
     * @return string
     */
    public function getCapture()
    {
        return $this->capture;
    }
}
