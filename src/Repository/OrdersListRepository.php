<?php

namespace App\Repository;

use App\Entity\OrdersList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrdersList|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdersList|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdersList[]    findAll()
 * @method OrdersList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdersList::class);
    }

    // /**
    //  * @return OrdersList[] Returns an array of OrdersList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdersList
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
