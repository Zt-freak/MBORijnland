<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntryRepository")
 */
class Entry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enquete", inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Enquete;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Awnser", mappedBy="Entry", orphanRemoval=true)
     */
    private $awnsers;

    public function __construct()
    {
        $this->awnsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getEnquete(): ?Enquete
    {
        return $this->Enquete;
    }

    public function setEnquete(?Enquete $Enquete): self
    {
        $this->Enquete = $Enquete;

        return $this;
    }

    /**
     * @return Collection|Awnser[]
     */
    public function getAwnsers(): Collection
    {
        return $this->awnsers;
    }

    public function addAwnser(Awnser $awnser): self
    {
        if (!$this->awnsers->contains($awnser)) {
            $this->awnsers[] = $awnser;
            $awnser->setEntry($this);
        }

        return $this;
    }

    public function removeAwnser(Awnser $awnser): self
    {
        if ($this->awnsers->contains($awnser)) {
            $this->awnsers->removeElement($awnser);
            // set the owning side to null (unless already changed)
            if ($awnser->getEntry() === $this) {
                $awnser->setEntry(null);
            }
        }

        return $this;
    }
}
