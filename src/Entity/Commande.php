<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fk_panier", columns={"id_Panier"}), @ORM\Index(name="id_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="fk_payment", columns={"id_Payment"})})
 * @ORM\Entity(repositoryClass=App\Repository\CommandeRepository::class)
 */
class Commande
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var float
     *
     * @ORM\Column(name="Prix_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="date_creation_commande", type="text", length=16777215, nullable=false)
     */
    private $dateCreationCommande;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_Panier", type="integer", nullable=true)
     */
    private $idPanier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_Payment", type="integer", nullable=true)
     */
    private $idPayment;


}
