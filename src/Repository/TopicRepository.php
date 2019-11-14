<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }


    public function activatedTopics()
    {
        return $this->createQueryBuilder('t')
            ->select("COUNT('*') as posts, t.Name as name, t.description as description, t.Path as path")
            ->from('App:Post', 'p')
            ->andWhere('t.id = p.Topic')
            ->andWhere('t.Accepted = 1')
            ->groupBy('p.Topic')
            ->orderBy('posts', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function mostCommented ($accepted)
    {
        return $this->createQueryBuilder('t')
            ->select("COUNT('*') as posts, t.id as id, t.Name as name, t.description as description, t.Path as path")
//            ->from('App:Topic', 't')
            ->from('App:Post', 'p')
            ->andWhere('t.id = p.Topic')
            ->andWhere('t.Accepted = :accepted')
            ->setParameter('accepted', $accepted)
            ->groupBy('p.Topic')
            ->orderBy('posts', 'DESC')
            ->getQuery()
            ->getResult();
    }
//SELECT COUNT(*), t.name FROM `view` as v, post as p, topic as t WHERE v.post_id = p.id and p.topic_id = t.id GROUP BY t.id
    public function mostViewed ()
    {
        return $this->createQueryBuilder('t')
            ->select("COUNT('*') as views, t.id as id")
            ->from('App:Post', 'p')
            ->from('App:View', 'v')
            ->andWhere('v.Post = p.id')
            ->andWhere('t.id = p.Topic')
            ->groupBy('t.id')
            ->orderBy('views', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Topic[] Returns an array of Topic objects
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
    public function findOneBySomeField($value): ?Topic
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
