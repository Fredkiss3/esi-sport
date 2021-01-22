<?php

namespace App\Repository\Magazine;

use App\Entity\Magazine\InfoFlash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoFlash|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoFlash|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoFlash[]    findAll()
 * @method InfoFlash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoFlashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoFlash::class);
    }

    /**
     * @return InfoFlash[] Returns an array of InfoFlash objects
     */
    public function findPublished()
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.publishedAt is not NULL')
            ->orderBy('i.publishedAt', 'DESC')
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?InfoFlash
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
