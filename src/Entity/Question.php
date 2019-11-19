<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enquete", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Enquete;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionOption", mappedBy="Question", orphanRemoval=true)
     */
    private $questionOptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Awnser", mappedBy="Question", orphanRemoval=true)
     */
    private $awnsers;

    public function __construct()
    {
        $this->questionOptions = new ArrayCollection();
        $this->awnsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    public function getType(): ?QuestionType
    {
        return $this->Type;
    }

    public function setType(?QuestionType $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return Collection|QuestionOption[]
     */
    public function getQuestionOptions(): Collection
    {
        return $this->questionOptions;
    }

    public function addQuestionOption(QuestionOption $questionOption): self
    {
        if (!$this->questionOptions->contains($questionOption)) {
            $this->questionOptions[] = $questionOption;
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionOption(QuestionOption $questionOption): self
    {
        if ($this->questionOptions->contains($questionOption)) {
            $this->questionOptions->removeElement($questionOption);
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

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
            $awnser->setQuestion($this);
        }

        return $this;
    }

    public function removeAwnser(Awnser $awnser): self
    {
        if ($this->awnsers->contains($awnser)) {
            $this->awnsers->removeElement($awnser);
            // set the owning side to null (unless already changed)
            if ($awnser->getQuestion() === $this) {
                $awnser->setQuestion(null);
            }
        }

        return $this;
    }
}
