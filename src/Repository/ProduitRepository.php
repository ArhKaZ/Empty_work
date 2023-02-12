<?php

namespace App\Repository;

use App\Data\SearchProduit;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
    public function findSearch(SearchProduit $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.collection', 'c')
            ->join('p.taille', 't')
            ->join('t.article', 'a')
        ;

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.ref LIKE :q')
                ->setParameter('q', "%{$search->q}%")
            ;
        }

        if (!empty($search->collections)) {
            $query = $query
                ->andWhere('c.id IN (:colletions)')
                ->setParameter('colletions', $search->collections)
            ;
        }

        if (!empty($search->articles)) {
            $query = $query
                ->andWhere('a.id IN (:articles)')
                ->setParameter('articles', $search->articles)
            ;
        }

        if (!empty($search->dans_catalogue)) {
            $query = $query
                ->andWhere('p.dans_catalogue = 1')
            ;
        }

        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            50
        );
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getQueryDansCatalogue()
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.dans_catalogue = 1')
        ;
    }
}
