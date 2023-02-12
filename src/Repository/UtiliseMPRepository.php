<?php

namespace App\Repository;

use App\Entity\UtiliseMP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UtiliseMP|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtiliseMP|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtiliseMP[]    findAll()
 * @method UtiliseMP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtiliseMPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UtiliseMP::class);
    }

    // /**
    //  * @return UtiliseMP[] Returns an array of UtiliseMP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UtiliseMP
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
