<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use App\Repository\ParticipantChatRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;


class MessageController extends AbstractController
{

    const ATTRIBUTES_TO_SERIALIZE=["id","Contenu","date_envoi","mine"];

    private $entityManagerInterface;
    private $messageRepository;
    private $utilisateurRepository;
    private $conversationRepository;
    private $serializer;
    private $participantRepository;
   


    public function __construct(EntityManagerInterface $entityManagerInterface, MessageRepository $messageRepository,
    UtilisateurRepository $utilisateurRepository,
    ConversationRepository $conversationRepository, 
    SerializerInterface $serializer,
    ParticipantChatRepository $participantRepository,
 )
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->messageRepository = $messageRepository;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->conversationRepository = $conversationRepository;
        $this->serializer = $serializer;
        $this->participantRepository = $participantRepository;
      


    }

    #[Route('/front', name: 'front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    #[Route('/iheb/{id}', name: 'get_messages')]
    public function getMessages(int $id)
    {
        // Récupérer la conversation à partir de l'identifiant
        $conversation = $this->entityManagerInterface->getRepository(Conversation::class)->find($id);

        // Vérifier si la conversation existe
        if (!$conversation) {
            throw $this->createNotFoundException('Conversation non trouvée pour l\'identifiant ' . $id);
        }

        // Vérifier l'accès à la conversation
        $this->denyAccessUnlessGranted('vi', $conversation);

        // Récupérer les messages de la conversation
        $messages = $this->messageRepository->findMessageByConversationId($id);

       array_map(function ( Message $message){
$message->SetMine(
    $message->getUtilisateur()->getId() === $this->getUser()->getId()
     ? true : false
);
       },$messages);
return $this->json($messages,Response::HTTP_OK,[],[
    'attributes'=>self::ATTRIBUTES_TO_SERIALIZE
]);
       
    } 
#[Route('/message/{id}', name: 'newMessages')]
public function newMessage(Request $request, $id)
{
    $user = $this->utilisateurRepository->findOneBy(['id' => 4]);
    // Récupérer la conversation à partir de son identifiant
    $conversation = $this->conversationRepository->find($id);

    // Vérifier si la conversation existe
    if (!$conversation) {
        throw $this->createNotFoundException('Conversation not found');
    }

    // Récupérer l'identifiant de l'utilisateur
    $userId = $this->getUser();

    // Validation du contenu
    $content = $request->get('Contenu');
    /*if (empty($content)) {
        throw new \InvalidArgumentException('Missing message content');
    }*/

    // Création du message
    $message = new Message();
    $message->setContenu($content);
    $message->setUtilisateur($user);
    $message->setMine(true);
    $message->setCreatedAt(new \DateTimeImmutable());
    $conversation->addMessage($message);

    // Enregistrement en base de données
    $this->entityManagerInterface->getConnection()->beginTransaction();
    try {
        $this->entityManagerInterface->persist($message);
        $this->entityManagerInterface->persist($conversation);
        $this->entityManagerInterface->flush();
        $this->entityManagerInterface->commit();
    } catch (\Exception $e) {
        $this->entityManagerInterface->rollback();
        throw $e;
    }

    // Envoi du message au serveur WebSocket
    $socketMessage = json_encode([
        'type' => 'new_message',
        'data' => [
            'id' => $message->getId(),
            'contenu' => $message->getContenu(),
            'date_envoi' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
            'mine' => true, // C'est votre propre message, vous pouvez l'ajuster selon vos besoins
            'conversation' => ['id' => $conversation->getId()]

            // Ajoutez d'autres données du message si nécessaire
        ]
    ]);
    $socket = stream_socket_client('tcp://localhost:3001', $errno, $errstr, 30);
    fwrite($socket, $socketMessage);
    dd($socketMessage);
    fclose($socket);

    // Récupérer tous les messages de la conversation
    $messages = $this->messageRepository->findBy(['conversation' => $id]);

    // Renvoyer les messages au fichier Twig
    return $this->render('message/message.html.twig', [
        'messages' => $messages,
    ]);

    return $this->json([
        'message' => $message,
    ], Response::HTTP_CREATED, [], ['attributes' => self::ATTRIBUTES_TO_SERIALIZE]);
}
}
