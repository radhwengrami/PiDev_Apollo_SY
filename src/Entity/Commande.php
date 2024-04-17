<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    #[Assert\LessThan(
        value: 'today',
        message: "La date doit être inférieure à la date d'aujourd'hui."
    )]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?int $idUser = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?string $etat = null;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private ?Panier $panier = null;

    #[ORM\ManyToMany(targetEntity: Oeuvre::class)]
    #[Assert\NotBlank(message: "ce champ ne peut pas être vide.")]
    private Collection $oeuvres;

    

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

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

    

    
}
