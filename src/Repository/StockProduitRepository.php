<?php

namespace App\Repository;

use App\Entity\StockProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockProduit[]    findAll()
 * @method StockProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockProduit::class);
    }

    // /**
    //  * @return StockProduit[] Returns an array of StockProduit objects
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
    public function findOneBySomeField($value): ?StockProduit
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
