<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="userSeries")
 */
class UserSeries
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Series", inversedBy="userSeries")
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity="UserSeason", inversedBy="userSeries")
     * @ORM\JoinColumn(nullable=true)
     */
    private $season;

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
     * Set visible
     *
     * @param boolean $visible
     *
     * @return UserSeries
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set series
     *
     * @param \AppBundle\Entity\Series $series
     *
     * @return UserSeries
     */
    public function setSeries(\AppBundle\Entity\Series $series = null)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return \AppBundle\Entity\Series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set season
     *
     * @param \AppBundle\Entity\User\UserSeason $season
     *
     * @return UserSeries
     */
    public function setSeason(\AppBundle\Entity\User\UserSeason $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \AppBundle\Entity\User\UserSeason
     */
    public function getSeason()
    {
        return $this->season;
    }
}
