<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Mise;
#[ORM\Entity(repositoryClass: EnchereRepository::class)]
#[Vich\Uploadable]
class Enchere
{
    //use TimeImmutable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le type d'oeuvre ne peut pas être vide")]
    #[ORM\Column(length: 255)]
    private ?string $type_oeuvre = null;


    #[Assert\NotNull(message: "Le montant minimum ne peut pas être vide")]
    #[Assert\GreaterThan(value: 0, message: "Le montant minimum doit être supérieur à zéro")]
    #[ORM\Column]
    private ?float $min_montant = null;
// NOTE: This is not a mapped field of entity metadata, just a simple property.
   
/**
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Veuillez télécharger une image au format JPEG ou PNG"
     * )
     */
#[Vich\UploadableField(mapping: 'enchere_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;
    #[ORM\Column(length: 255)]
   
private ?string $image = null;

#[Assert\NotNull(message: "La date de début ne peut pas être vide")]
#[Assert\NotBlank(message: "Veuillez saisir une Date")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;
    #[Assert\NotNull(message: "La date de fin ne peut pas être vide")]
    #[Assert\NotBlank(message: "Veuillez saisir une Date")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column]
    private ?int $id_utilisateur = null;

    #[ORM\OneToMany(targetEntity: Mise::class, mappedBy: 'enchers', cascade: ["remove"])]
    private Collection $mises;

    public function __construct()
    {
        $this->mises = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeOeuvre(): ?string
    {
        return $this->type_oeuvre;
    }

    public function setTypeOeuvre(string $type_oeuvre): static
    {
        $this->type_oeuvre = $type_oeuvre;

        return $this;
    }

    public function getMinMontant(): ?float
    {
        return $this->min_montant;
    }

    public function setMinMontant(float $min_montant): static
    {
        $this->min_montant = $min_montant;

        return $this;
    }

//    #[ORM\Column(nullable: true)]
//    private ?\DateTimeImmutable $updatedAt = null;
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile( $imageFile = null): void
    {
        $this->imageFile = $imageFile;

//        if (null !== $imageFile) {
//            // It is required that at least one field changes if you are using doctrine
//            // otherwise the event listeners won't be called and the file is lost
//            $this->setDateDebut(new \DateTimeImmutable);
//        }
   }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
    
        return $this;
    }
    

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Mise>
     */
    public function getMises(): Collection
    {
        return $this->mises;
    }

    public function addMise(Mise $mise): static
    {
        if (!$this->mises->contains($mise)) {
            $this->mises->add($mise);
            $mise->setEnchers($this);
        }

        return $this;
    }



    public function removeMise(Mise $mise): static
    {
        if ($this->mises->removeElement($mise)) {
            // set the owning side to null (unless already changed)
            if ($mise->getEnchers() === $this) {
                $mise->setEnchers(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->type_oeuvre;
    }

}
