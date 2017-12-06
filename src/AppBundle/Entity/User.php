<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $password;
}