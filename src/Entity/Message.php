<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_conversation", columns={"conversation_id"}), @ORM\Index(name="fk_utilisateur", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass=App\Repository\MessageRepository::class)
 *
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=true)
     */
    private $idUtilisateur;

    /**
     * @var int|null
     *
     * @ORM\Column(name="conversation_id", type="integer", nullable=true)
     */
    private $conversationId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateEnvoi = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;


}
