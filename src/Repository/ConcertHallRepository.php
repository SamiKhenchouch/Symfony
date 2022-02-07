<?php

namespace App\Repository;

use App\Entity\ConcertHall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConcertHall|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcertHall|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcertHall[]    findAll()
 * @method ConcertHall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertHallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcertHall::class);
    }

    // /**
    //  * @return ConcertHall[] Returns an array of ConcertHall objects
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
    public function findOneBySomeField($value): ?ConcertHall
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
