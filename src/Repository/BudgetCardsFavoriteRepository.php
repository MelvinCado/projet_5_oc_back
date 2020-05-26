<?php

namespace App\Repository;

use App\Entity\BudgetCardsFavorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BudgetCardsFavorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetCardsFavorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetCardsFavorite[]    findAll()
 * @method BudgetCardsFavorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetCardsFavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetCardsFavorite::class);
    }

    // /**
    //  * @return BudgetCardsFavorite[] Returns an array of BudgetCardsFavorite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BudgetCardsFavorite
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
