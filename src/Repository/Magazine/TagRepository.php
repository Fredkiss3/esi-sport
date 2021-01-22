<?php

namespace App\Repository\Magazine;

use App\Entity\Magazine\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @return Tag[] Returns an array of Tag objects
     */
    public function findWithArticleCount()
    {
//        $query = $this->getEntityManager()->createQuery("
//    SELECT t.tag, COUNT(arts) as total
//    FROM App\Entity\Magazine\Tag as t
//    LEFT JOIN t.articles as arts
//    GROUP BY t.tag
//    ");
        $qs = $this->createQueryBuilder('t');

        $qs->addSelect($qs->expr()->count('a'))
            ->leftJoin('t.articles', 'a')
            ->andWhere("a.publishedAt IS NOT NULL")
            ->groupBy('t.id');

        return $qs
//            ->leftJoin("t.articles", "articles")
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
