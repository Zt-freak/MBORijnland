<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ViewRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class View
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="views")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="views")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $viewed_at;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {

        if ($this->getViewedAt() === null) {
            $this->setViewedAt(new \DateTime('now'));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setPost(?Post $Post): self
    {
        $this->Post = $Post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getViewedAt(): ?\DateTimeInterface
    {
        return $this->viewed_at;
    }

    public function setViewedAt(\DateTimeInterface $viewed_at): self
    {
        $this->viewed_at = $viewed_at;

        return $this;
    }
}
