<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicWhitelistRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TopicWhitelist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="topicWhitelists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Topic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="topicWhitelists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="datetime")
     */
    private $WhitelistedAt;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        if ($this->getWhitelistedAt() === null) {
            $this->setWhitelistedAt(new \DateTime('now'));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopic(): ?Topic
    {
        return $this->Topic;
    }

    public function setTopic(?Topic $Topic): self
    {
        $this->Topic = $Topic;

        return $this;
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

    public function getWhitelistedAt(): ?\DateTimeInterface
    {
        return $this->WhitelistedAt;
    }

    public function setWhitelistedAt(\DateTimeInterface $WhitelistedAt): self
    {
        $this->WhitelistedAt = $WhitelistedAt;

        return $this;
    }
}
