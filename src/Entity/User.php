<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
// src/Entity/User.php
namespace App\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();

        $this->roles = array('ROLE_USER');
        $this->orders = new ArrayCollection();
    }

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location", mappedBy="User", cascade={"persist", "remove"})
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="user")
     */
    private $orders;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $location === null ? null : $this;
        if ($newUser !== $location->getUser()) {
            $location->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
