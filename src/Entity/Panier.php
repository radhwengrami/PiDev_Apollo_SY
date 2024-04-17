<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?int $idUser = null;

    #[ORM\ManyToMany(targetEntity: Oeuvre::class, inversedBy: 'paniers')]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private Collection $oeuvres;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?string $accecible = null;

    

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, Oeuvre>
     */
    public function getOeuvres(): Collection
    {
        return $this->oeuvres;
    }

    public function addOeuvre(Oeuvre $oeuvre): static
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres->add($oeuvre);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        $this->oeuvres->removeElement($oeuvre);

        return $this;
    }

    public function getAccecible(): ?string
    {
        return $this->accecible;
    }

    public function setAccecible(string $accecible): static
    {
        $this->accecible = $accecible;

        return $this;
    }

    
}
