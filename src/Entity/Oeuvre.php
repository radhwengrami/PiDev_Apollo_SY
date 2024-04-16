<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oeuvre
 *
 * @ORM\Table(name="oeuvre", indexes={@ORM\Index(name="fk_portfolio", columns={"id_portfolio"})})
 * @ORM\Entity(repositoryClass=App\Repository\OeuvreRepository::class)
 *
 */
class Oeuvre
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
     * @ORM\Column(name="id_Oeuvre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOeuvre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image_oeuvre", type="string", length=255, nullable=false)
     */
    private $imageOeuvre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="dimension", type="string", length=255, nullable=false)
     */
    private $dimension;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var bool
     *
     * @ORM\Column(name="disponibilite", type="boolean", nullable=false)
     */
    private $disponibilite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true, options={"default"="1"})
     */
    private $quantite = 1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;


}
