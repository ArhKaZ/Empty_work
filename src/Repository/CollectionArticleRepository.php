<?php

namespace App\Repository;

use App\Entity\CollectionArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionArticle[]    findAll()
 * @method CollectionArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionArticle::class);
    }

    // /**
    //  * @return CollectionArticle[] Returns an array of CollectionArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CollectionArticle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
