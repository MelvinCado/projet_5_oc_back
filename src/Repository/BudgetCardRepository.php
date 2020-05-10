<?php

namespace App\Repository;

use App\Entity\BudgetCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BudgetCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetCard[]    findAll()
 * @method BudgetCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetCard::class);
    }

    // /**
    //  * @return BudgetCard[] Returns an array of BudgetCard objects
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
    public function findOneBySomeField($value): ?BudgetCard
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
