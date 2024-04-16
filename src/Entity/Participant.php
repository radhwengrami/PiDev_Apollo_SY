<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant", indexes={@ORM\Index(name="fk_event", columns={"id_evenement"}), @ORM\Index(name="fk_participant", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass=App\Repository\ParticipantRepository::class)
 *
 */
class Participant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_participant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParticipant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_evenement", type="integer", nullable=true)
     */
    private $idEvenement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;


}
