<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $trainingName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainingName(): ?string
    {
        return $this->trainingName;
    }

    public function setTrainingName(string $trainingName): static
    {
        $this->trainingName = $trainingName;

        return $this;
    }
}
