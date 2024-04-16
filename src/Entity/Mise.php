<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mise
 *
 * @ORM\Table(name="mise", indexes={@ORM\Index(name="fk_user", columns={"id_utilisateur"}), @ORM\Index(name="fk_encher", columns={"id_enchers"})})
 * @ORM\Entity(repositoryClass=App\Repository\MiseRepository::class)
 */
class Mise
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mise", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMise;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_enchers", type="integer", nullable=true)
     */
    private $idEnchers;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var float
     *
     * @ORM\Column(name="max_montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $maxMontant;


}
