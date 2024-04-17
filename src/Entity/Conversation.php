<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le sujet ne peut pas être vide")]
    #[Assert\Length(max: 30, maxMessage: "Le sujet ne peut pas dépasser {{ limit }} caractères")]
    private ?string $Sujet = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    #[Assert\Length(max: 30, maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères")]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(max:100,maxMessage:(' Entre une description de taille de caractére  maximum{{ limit }}.'))]
    private ?string $Description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creation = null;


    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ["DUO", "GROUP"], message: "Le type de conversation doit être 'public' ou 'privé'")]

    private ?string $Type_Conversation = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ["PUBLIC", "PRIVATE"], message: "La visibilité doit être 'public' ou 'privee'")]
    private ?string $Visibilite = null;
    
    #[ORM\OneToMany(targetEntity: ParticipantChat::class, mappedBy: 'conversation')]
   
    
    private Collection $Participants;
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'conversation')]

    private Collection $messages;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Message $dernier_message = null;

    public function __construct()
    {
        $this->Participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->Sujet;
    }

    public function setSujet(string $Sujet): static
    {
        $this->Sujet = $Sujet;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getdateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setdateCreation(\DateTimeImmutable $CreatedAt): static
    {
        $this->date_creation = $CreatedAt;

        return $this;
    }

    public function getTypeConversation(): ?string
    {
        return $this->Type_Conversation;
    }

    public function setTypeConversation(string $Type_Conversation): static
    {
        $this->Type_Conversation = $Type_Conversation;

        return $this;
    }

    public function getVisibilite(): ?string
    {
        return $this->Visibilite;
    }

    public function setVisibilite(string $Visibilite): static
    {
        $this->Visibilite = $Visibilite;

        return $this;
    }

    /**
     * @return Collection<int, ParticipantChat>
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(ParticipantChat $participant): static
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants->add($participant);
            $participant->setConversation($this);
        }

        return $this;
    }

    public function removeParticipant(ParticipantChat $participant): static
    {
        if ($this->Participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getConversation() === $this) {
                $participant->setConversation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }

        return $this;
    }

    public function getDernierMessage(): ?Message
    {
        return $this->dernier_message;
    }

    public function setDernierMessage(?Message $dernier_message): static
    {
        $this->dernier_message = $dernier_message;

        return $this;
    }
}
