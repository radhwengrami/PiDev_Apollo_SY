<?php

namespace App\Repository;

use App\Entity\ParticipantChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParticipantChat>
 *
 * @method ParticipantChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipantChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipantChat[]    findAll()
 * @method ParticipantChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipantChat::class);
    }

//    /**
//     * @return ParticipantChat[] Returns an array of ParticipantChat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParticipantChat
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findParticipantByConversationAndUserId(int $conversationId, int $userId)
{
    $qb = $this->createQueryBuilder('p');
    $qb->where(
        $qb->expr()->andX(
            $qb->expr()->eq('p.conversation', ':conversationId'),
            $qb->expr()->neq('p.utilisateur', ':userId')
        )
    );

    // Définir chaque paramètre séparément
    $qb->setParameter('conversationId', $conversationId);
    $qb->setParameter('userId', $userId);

    // En supposant que vous attendiez soit une seule entité Participant, soit null
    return $qb->getQuery()->getOneOrNullResult();
}


}
