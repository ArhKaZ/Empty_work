<?php

namespace App\Repository;

use App\Entity\MatierePremiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatierePremiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatierePremiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatierePremiere[]    findAll()
 * @method MatierePremiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatierePremiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatierePremiere::class);
    }

    /**
     * @return MatierePremiere[]
     */
    public function findFourniture(): array
    {
        return $this
            ->getQueryFourniture()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MatierePremiere[]
     */
    public function findTissu(): array
    {
        return $this
            ->getQueryTissu()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryFourniture(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('mp')
            ->where('mp.type LIKE :t')
            ->setParameter('t', 'fourniture')
            ;
    }


    /**
     * @return QueryBuilder
     */
    public function getQueryTissu(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('mp')
            ->where('mp.type LIKE :t')
            ->setParameter('t', 'tissu')
            ;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryNoeud(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('mp')
            ->where('mp.type LIKE :t')
            ->setParameter('t', 'noeud')
            ;
    }


    // /**
    //  * @return MatierePremiere[] Returns an array of MatierePremiere objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MatierePremiere
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
