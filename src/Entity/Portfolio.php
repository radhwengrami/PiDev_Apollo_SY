<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Portfolio
 *
 * @ORM\Table(name="portfolio", indexes={@ORM\Index(name="uk_oeuvre", columns={"id_user"})})
 * @ORM\Entity(repositoryClass=App\Repository\PortfolioRepository::class)
 * */
class Portfolio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_portfolio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPortfolio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_Artistique", type="string", length=255, nullable=false)
     */
    private $nomArtistique;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255, nullable=false)
     */
    private $imageurl;

    /**
     * @var string
     *
     * @ORM\Column(name="biographie", type="string", length=1000, nullable=false)
     */
    private $biographie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut_carriere", type="date", nullable=false)
     */
    private $debutCarriere;

    /**
     * @var string
     *
     * @ORM\Column(name="reseau_sociaux", type="string", length=255, nullable=false)
     */
    private $reseauSociaux;


}
