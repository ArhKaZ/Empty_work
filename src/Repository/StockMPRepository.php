<?php

namespace App\Repository;

use App\Entity\StockMP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockMP|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockMP|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockMP[]    findAll()
 * @method StockMP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockMPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockMP::class);
    }

    // /**
    //  * @return StockMP[] Returns an array of StockMP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StockMP
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
