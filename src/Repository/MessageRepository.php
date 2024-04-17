<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Conversation;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


public function findMessageByConversationId(int $conversationId){
    $qb= $this->createQueryBuilder("m");
    $qb->
    where('m.conversation= :conversationId')
    ->setParameter('conversationId',$conversationId)
    ->orderBy('m.id','DESC');

    return   $qb->getQuery()->getResult();
}

public function updateLastMessage(Conversation $conversation): void
{
    // Récupérer le dernier message de la conversation
    $lastMessage = $this->findLastMessage($conversation);

    // Mettre à jour l'attribut "dernier_message" de la conversation avec le dernier message trouvé
    $conversation->setDernierMessage($lastMessage);

    // Enregistrer les modifications en base de données
    $this->_em->persist($conversation);
    $this->_em->flush();
}


public function findLastMessage(Conversation $conversation): ?Message
{
    return $this->createQueryBuilder('c')
        ->select('m')
        ->from('App\Entity\Message', 'm')
        ->where('m.conversation = :conversation')
        ->orderBy('m.date_envoi', 'DESC')
        ->setParameter('conversation', $conversation)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}
}

?>