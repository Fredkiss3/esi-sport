<?php

namespace App\Repository;

use App\Entity\InterEcole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InterEcole|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterEcole|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterEcole[]    findAll()
 * @method InterEcole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterEcoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterEcole::class);
    }

    // /**
    //  * @return InterEcole[] Returns an array of InterEcole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InterEcole
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
