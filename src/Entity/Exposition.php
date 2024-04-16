<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exposition
 *
 * @ORM\Table(name="exposition", indexes={@ORM\Index(name="fk_portfolioexpo", columns={"id_portfolio"})})
 * @ORM\Entity(repositoryClass=App\Repository\ExpositionRepository::class)
 *
 */
class Exposition
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id_portfolio", type="integer", nullable=true)
     */
    private $idPortfolio;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Exposition", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExposition;

    /**
     * @var string
     *
     * @ORM\Column(name="image_affiche", type="string", length=255, nullable=false)
     */
    private $imageAffiche;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

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
     * @var string|null
     *
     * @ORM\Column(name="type_expo", type="string", length=255, nullable=true)
     */
    private $typeExpo;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;


}
