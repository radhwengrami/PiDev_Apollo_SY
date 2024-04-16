<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipantChat
 *
 * @ORM\Table(name="participant_chat", indexes={@ORM\Index(name="fk_conversationa", columns={"conversation_id"}), @ORM\Index(name="fk_usera", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass=App\Repository\ParticipantChatRepository::class)
 *
 */
class ParticipantChat
{
    /**
     * @var int
     *
     * @ORM\Column(name="participant_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $participantId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="conversation_id", type="integer", nullable=true)
     */
    private $conversationId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;


}
