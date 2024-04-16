<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enchers
 *
 * @ORM\Table(name="enchers", indexes={@ORM\Index(name="fk_enchers", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass=App\Repository\EnchersRepository::class)
 *
 */
class Enchers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_enchers", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEnchers;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="type_oeuvre", type="string", length=255, nullable=false)
     */
    private $typeOeuvre;

    /**
     * @var float
     *
     * @ORM\Column(name="min_montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $minMontant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;


}
