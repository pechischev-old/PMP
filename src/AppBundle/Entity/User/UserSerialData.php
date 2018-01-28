<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="userSerialData")
 */
class UserSerialData
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
    private $viewStatus;

    /**
     * @ORM\OneToMany(targetEntity="UserSeason", mappedBy="serialData")
     */
    private $userSeason;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\SerialData")
     */
    private $serialData;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserHistory", inversedBy="userSerialData")
     * @ORM\JoinColumn(nullable=true)
     */
    private $history;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userSeason = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getParentId()
    {
        return $this->serialData->getId ();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->serialData->getTitle();
    }

    /**
     * @return integer
     */
    public function getYear()
    {
        return $this->serialData->getYear();
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->serialData->getRate();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $viewStatus
     * @return UserSerialData
     */
    public function setViewStatus($viewStatus)
    {
        $this->viewStatus = $viewStatus;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getViewStatus()
    {
        return $this->viewStatus;
    }

    /**
     * Add userSeason
     *
     * @param \AppBundle\Entity\User\UserSeason $userSeason
     *
     * @return UserSerialData
     */
    public function addUserSeason(\AppBundle\Entity\User\UserSeason $userSeason)
    {
        $this->userSeason[] = $userSeason;

        return $this;
    }

    /**
     * @param \AppBundle\Entity\User\UserSeason $userSeason
     */
    public function removeUserSeason(\AppBundle\Entity\User\UserSeason $userSeason)
    {
        $this->userSeason->removeElement($userSeason);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserSeason()
    {
        return $this->userSeason;
    }

    /**
     * @param \AppBundle\Entity\UserHistory $history
     * @return UserSerialData
     */
    public function setHistory(\AppBundle\Entity\UserHistory $history = null)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\UserHistory
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param \AppBundle\Entity\SerialData $serialData
     * @return UserSerialData
     */
    public function setSerialData(\AppBundle\Entity\SerialData $serialData = null)
    {
        $this->serialData = $serialData;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\SerialData
     */
    public function getSerialData()
    {
        return $this->serialData;
    }
}
