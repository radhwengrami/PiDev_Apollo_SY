<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass=App\Repository\ConversationRepository::class)
 * */
class Conversation
{
    /**
     * @var int
     *
     * @ORM\Column(name="conversation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $conversationId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sujet", type="string", length=255, nullable=true)
     */
    private $sujet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCreation = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="conversation_type", type="string", length=255, nullable=true)
     */
    private $conversationType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="visibilite", type="string", length=255, nullable=true)
     */
    private $visibilite;


}
