<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="userSeason")
 */
class UserSeason
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserSerialData", inversedBy="userSeason")
     * @ORM\JoinColumn(nullable=true)
     */
    private $serialData;

    /**
     * @ORM\OneToMany(targetEntity="UserSeries", mappedBy="season")
     */
    private $series;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibled;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Season", inversedBy="userSeason")
     */
    private $season;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->series = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set visibled
     *
     * @param boolean $visibled
     *
     * @return UserSeason
     */
    public function setVisibled($visibled)
    {
        $this->visibled = $visibled;

        return $this;
    }

    /**
     * Get visibled
     *
     * @return boolean
     */
    public function getVisibled()
    {
        return $this->visibled;
    }

    /**
     * Set serialData
     *
     * @param \AppBundle\Entity\User\UserSerialData $serialData
     *
     * @return UserSeason
     */
    public function setSerialData(\AppBundle\Entity\User\UserSerialData $serialData = null)
    {
        $this->serialData = $serialData;

        return $this;
    }

    /**
     * Get serialData
     *
     * @return \AppBundle\Entity\User\UserSerialData
     */
    public function getSerialData()
    {
        return $this->serialData;
    }

    /**
     * Add series
     *
     * @param \AppBundle\Entity\User\UserSeries $series
     *
     * @return UserSeason
     */
    public function addSeries(\AppBundle\Entity\User\UserSeries $series)
    {
        $this->series[] = $series;

        return $this;
    }

    /**
     * Remove series
     *
     * @param \AppBundle\Entity\User\UserSeries $series
     */
    public function removeSeries(\AppBundle\Entity\User\UserSeries $series)
    {
        $this->series->removeElement($series);
    }

    /**
     * Get series
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set season
     *
     * @param \AppBundle\Entity\Season $season
     *
     * @return UserSeason
     */
    public function setSeason(\AppBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \AppBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }
}
