<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="season")
 */
class Season
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Series", mappedBy="season")
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity="SerialData", inversedBy="season")
     * @ORM\JoinColumn(nullable=true)
     */
    private $serialData;
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
     * Set name
     *
     * @param integer $name
     *
     * @return Season
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return integer
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add series
     *
     * @param \AppBundle\Entity\Series $series
     *
     * @return Season
     */
    public function addSeries(\AppBundle\Entity\Series $series)
    {
        $this->series[] = $series;

        return $this;
    }

    /**
     * Remove series
     *
     * @param \AppBundle\Entity\Series $series
     */
    public function removeSeries(\AppBundle\Entity\Series $series)
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
     * Set serialData
     *
     * @param \AppBundle\Entity\SerialData $serialData
     *
     * @return Season
     */
    public function setSerialData(\AppBundle\Entity\SerialData $serialData = null)
    {
        $this->serialData = $serialData;

        return $this;
    }

    /**
     * Get serialData
     *
     * @return \AppBundle\Entity\SerialData
     */
    public function getSerialData()
    {
        return $this->serialData;
    }
}
