<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="User", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="User", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="User")
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TopicWhitelist", mappedBy="User")
     */
    private $topicWhitelists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\View", mappedBy="user")
     */
    private $views;

    public function __construct()
    {
        parent::__construct();

        $this->roles = array('ROLE_USER');
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->topicWhitelists = new ArrayCollection();
        $this->views = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

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
            $topicWhitelist->setUser($this);
        }

        return $this;
    }

    public function removeTopicWhitelist(TopicWhitelist $topicWhitelist): self
    {
        if ($this->topicWhitelists->contains($topicWhitelist)) {
            $this->topicWhitelists->removeElement($topicWhitelist);
            // set the owning side to null (unless already changed)
            if ($topicWhitelist->getUser() === $this) {
                $topicWhitelist->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|View[]
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): self
    {
        if (!$this->views->contains($view)) {
            $this->views[] = $view;
            $view->setUser($this);
        }

        return $this;
    }

    public function removeView(View $view): self
    {
        if ($this->views->contains($view)) {
            $this->views->removeElement($view);
            // set the owning side to null (unless already changed)
            if ($view->getUser() === $this) {
                $view->setUser(null);
            }
        }

        return $this;
    }
}
