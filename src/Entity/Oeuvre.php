<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{4}$/",
        message: "Le champ doit contenir exactement 4 chiffres."
    )]
    #[Assert\LessThanOrEqual(
        value: 2024,
        message: "La valeur maximale du champ est 2024."
    )]
    private ?string $anne_creation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d+\/\d+$/",
        message: "Le format doit être 'numbers/numbers'."
    )]
    private ?string $dimention = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    #[Assert\Type(
        type: "float",
        message: "Le champ doit être un nombre décimal (float)."
    )]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?bool $disponibilite = null;

    #[ORM\ManyToMany(targetEntity: Panier::class, mappedBy: 'oeuvres')]
    private Collection $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneCreation(): ?string
    {
        return $this->anne_creation;
    }

    public function setAnneCreation(string $anne_creation): static
    {
        $this->anne_creation = $anne_creation;

        return $this;
    }

    public function getDimention(): ?string
    {
        return $this->dimention;
    }

    public function setDimention(string $dimention): static
    {
        $this->dimention = $dimention;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->addOeuvre($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            $panier->removeOeuvre($this);
        }

        return $this;
    }

    
}
