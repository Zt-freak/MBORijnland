<?php

namespace App\Repository;

use App\Entity\TopicWhitelist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TopicWhitelist|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopicWhitelist|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopicWhitelist[]    findAll()
 * @method TopicWhitelist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicWhitelistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TopicWhitelist::class);
    }

    // /**
    //  * @return TopicWhitelist[] Returns an array of TopicWhitelist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TopicWhitelist
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
