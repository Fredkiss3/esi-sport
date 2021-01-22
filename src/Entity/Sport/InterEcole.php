<?php

namespace App\Entity;

use App\Domain\Repository\InterEcoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterEcoleRepository::class)
 */
class InterEcole
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
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=EncounterInterEcole::class, mappedBy="tournament", orphanRemoval=true)
     */
    private $encouters;

    public function __construct()
    {
        $this->encouters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|EncounterInterEcole[]
     */
    public function getEncouters(): Collection
    {
        return $this->encouters;
    }

    public function addEncouter(EncounterInterEcole $encouter): self
    {
        if (!$this->encouters->contains($encouter)) {
            $this->encouters[] = $encouter;
            $encouter->setTournament($this);
        }

        return $this;
    }

    public function removeEncouter(EncounterInterEcole $encouter): self
    {
        if ($this->encouters->removeElement($encouter)) {
            // set the owning side to null (unless already changed)
            if ($encouter->getTournament() === $this) {
                $encouter->setTournament(null);
            }
        }

        return $this;
    }
}
