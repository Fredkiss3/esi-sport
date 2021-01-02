<?php

namespace App\Entity;

use App\Repository\EncounterInterEcoleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EncounterInterEcoleRepository::class)
 */
class EncounterInterEcole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Encounter::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $encounter;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity=InterEcole::class, inversedBy="encouters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getTournament(): ?InterEcole
    {
        return $this->tournament;
    }

    public function setTournament(?InterEcole $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }
}
