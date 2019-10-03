<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="topics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Path;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Accepted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TopicWhitelist", mappedBy="Topic")
     */
    private $topicWhitelists;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="Topic", orphanRemoval=true)
     */
    private $posts;

    public function __construct()
    {
        $this->topicWhitelists = new ArrayCollection();
        $this->posts = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->Path;
    }

    public function setPath(string $Path): self
    {
        $this->Path = $Path;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->Accepted;
    }

    public function setAccepted(bool $Accepted): self
    {
        $this->Accepted = $Accepted;

        return $this;
    }

    /**
     * @return Collection|TopicWhitelist[]
     */
    public function getTopicWhitelists(): Collection
    {
        return $this->topicWhitelists;
    }

    public function addTopicWhitelist(TopicWhitelist $topicWhitelist): self
    {
        if (!$this->topicWhitelists->contains($topicWhitelist)) {
            $this->topicWhitelists[] = $topicWhitelist;
            $topicWhitelist->setTopic($this);
        }

        return $this;
    }

    public function removeTopicWhitelist(TopicWhitelist $topicWhitelist): self
    {
        if ($this->topicWhitelists->contains($topicWhitelist)) {
            $this->topicWhitelists->removeElement($topicWhitelist);
            // set the owning side to null (unless already changed)
            if ($topicWhitelist->getTopic() === $this) {
                $topicWhitelist->setTopic(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setTopic($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getTopic() === $this) {
                $post->setTopic(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
