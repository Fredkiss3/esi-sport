<?php

namespace App\Entity;

use App\Repository\EncounterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Faker\Provider\DateTime;

/**
 * @ORM\Entity(repositoryClass=EncounterRepository::class)
 */
class Encounter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreClub1 = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $scoreClub2 = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasFinished = false;

    /**
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="encounter", orphanRemoval=true)
     */
    private $goals;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
        $this->date = new \DateTime;
        $this->label = "Match du " . $this->date->format("d/m/Y");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScoreClub1(): ?int
    {
        return $this->scoreClub1;
    }

    public function finishEncounter()
    {
        $this->setHasFinished(true);
    }

    public function setScoreClub1(int $scoreClub1): self
    {
        $this->scoreClub1 = $scoreClub1;

        return $this;
    }

    public function getScoreClub2(): ?int
    {
        return $this->scoreClub2;
    }

    public function setScoreClub2(int $scoreClub2): self
    {
        $this->scoreClub2 = $scoreClub2;

        return $this;
    }

    public function getHasFinished(): ?bool
    {
        return $this->hasFinished;
    }

    public function setHasFinished(bool $hasFinished): self
    {
        $this->hasFinished = $hasFinished;

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setEncounter($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->removeElement($goal)) {
            // set the owning side to null (unless already changed)
            if ($goal->getEncounter() === $this) {
                $goal->setEncounter(null);
            }
        }

        return $this;
    }
}
