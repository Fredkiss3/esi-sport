<?php

namespace App\Entity\Magazine;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\Magazine\InfoFlashRepository;

/**
 * @ORM\Entity(repositoryClass=InfoFlashRepository::class)
 */
class InfoFlash extends AbstractArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

}
