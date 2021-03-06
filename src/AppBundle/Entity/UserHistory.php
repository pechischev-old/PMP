<?php
/**
 * Created by PhpStorm.
 * User: Владимир
 * Date: 24.12.2017
 * Time: 19:48
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="userHistory")
 */
class UserHistory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User\UserSerialData", mappedBy="history")
     */
    private $serialData;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->serialData = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserHistory
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add serialDatum
     *
     * @param \AppBundle\Entity\User\UserSerialData $serialDatum
     *
     * @return UserHistory
     */
    public function addSerialDatum(\AppBundle\Entity\User\UserSerialData $serialDatum)
    {
        $this->serialData[] = $serialDatum;

        return $this;
    }

    /**
     * Remove serialDatum
     *
     * @param \AppBundle\Entity\User\UserSerialData $serialDatum
     */
    public function removeSerialDatum(\AppBundle\Entity\User\UserSerialData $serialDatum)
    {
        $this->serialData->removeElement($serialDatum);
    }

    /**
     * Get serialData
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSerialData()
    {
        return $this->serialData;
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

    public function hasSerial($serialId)
    {
        $arr =  $this->serialData->getValues();
        foreach ($arr as $element) {
            if ($element->getParentId() == $serialId ) {
                return true;
            }
        }
        return false;
    }
}
