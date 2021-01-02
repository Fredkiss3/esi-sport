<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GoalRepository::class)
 */
class Goal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="datetime")
     */
    private $scoredAt;

    /**
     * @ORM\ManyToOne(targetEntity=Encounter::class, inversedBy="goals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $encounter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getScoredAt(): ?\DateTimeInterface
    {
        return $this->scoredAt;
    }

    public function setScoredAt(\DateTimeInterface $scoredAt): self
    {
        $this->scoredAt = $scoredAt;

        return $this;
    }

    public function getEncounter(): ?Encounter
    {
        return $this->encounter;
    }

    public function setEncounter(?Encounter $encounter): self
    {
        $this->encounter = $encounter;

        return $this;
    }
}
