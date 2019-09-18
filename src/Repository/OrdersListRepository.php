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

    public function mostBought()
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o.product) as amount, IDENTITY(o.product) as product')
            ->groupBy('o.product')
            ->orderBy('amount', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }
}
