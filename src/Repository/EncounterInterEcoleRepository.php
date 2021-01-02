<?php

namespace App\Repository;

use App\Entity\EncounterInterEcole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EncounterInterEcole|null find($id, $lockMode = null, $lockVersion = null)
 * @method EncounterInterEcole|null findOneBy(array $criteria, array $orderBy = null)
 * @method EncounterInterEcole[]    findAll()
 * @method EncounterInterEcole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncounterInterEcoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EncounterInterEcole::class);
    }

    // /**
    //  * @return EncounterInterEcole[] Returns an array of EncounterInterEcole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EncounterInterEcole
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
