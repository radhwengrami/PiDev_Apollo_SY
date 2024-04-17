<?php

namespace App\Entity;

use App\Repository\MiseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MiseRepository::class)]
class Mise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private ?float $max_montant = null;

    #[ORM\ManyToOne(inversedBy: 'mises')]
    #[ORM\JoinColumn(name:'id_enchere')]
    private ?Enchere $enchers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxMontant(): ?float
    {
        return $this->max_montant;
    }

    public function setMaxMontant(float $max_montant): static
    {
        $this->max_montant = $max_montant;

        return $this;
    }

    public function getEnchers(): ?enchere
    {
        return $this->enchers;
    }

    public function setEnchers(?enchere $enchers): static
    {
        $this->enchers = $enchers;

        return $this;
    }



}
