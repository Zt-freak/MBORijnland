<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=85, nullable=true)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=85, nullable=true)
     */
    private $Street;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $HouseNumber;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $PhoneNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(?string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(?string $Street): self
    {
        $this->Street = $Street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->HouseNumber;
    }

    public function setHouseNumber(?string $HouseNumber): self
    {
        $this->HouseNumber = $HouseNumber;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }
}
