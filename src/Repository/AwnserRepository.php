<?php

namespace App\Repository;

use App\Entity\Awnser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Awnser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Awnser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Awnser[]    findAll()
 * @method Awnser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwnserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Awnser::class);
    }

    // /**
    //  * @return Awnser[] Returns an array of Awnser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Awnser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
