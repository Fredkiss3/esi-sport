<?php

namespace App\Repository\Magazine;

use App\Entity\Magazine\Article;
use App\Entity\Magazine\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function searchByTitle(string $title, int $page = 1)
    {
        $manager = $this->getEntityManager();
        $qs = $this->createQueryBuilder('a');

        $qs->addSelect($qs->expr()->count('c'))
            ->leftJoin('a.comments', 'c')
            ->groupBy('a.id');

        return $qs
            ->andWhere("a.title LIKE :title")
            ->setParameter("title", "%{$title}%")
            ->andWhere("a.publishedAt is not NULL")
            ->orderBy("a.publishedAt", "DESC")
//            ->setFirstResult(($page - 1) * 10)
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function searchByTag(string $tag, string $q = "")
    {
        $qs = $this->createQueryBuilder('a')
            ->join("a.tags", "tags")
            ->andWhere("tags.tag = :tag")
            ->andWhere("a.publishedAt is not NULL")
            ->setParameter("tag", $tag);

        $qs->addSelect($qs->expr()->count('c'))
            ->leftJoin('a.comments', 'c')
            ->groupBy('a.id');

        return $qs
            ->andWhere("a.title LIKE :title")
            ->setParameter("title", "%{$q}%")
            ->orderBy("a.publishedAt", "DESC")
//            ->setFirstResult(($page - 1) * 10)
//            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array|Tag[] $tags
     * @param int $exludeID
     * @return Article[] Returns an array of Article objects
     */
    public function findRelatedByTags($tags, int $exludeID)
    {
        $qs = $this->createQueryBuilder('a')
            ->join("a.tags", "tags")
            ->andWhere("a.id != :id")
            ->andWhere("a.publishedAt is not NULL")
            ->setParameter("id", $exludeID);

        for ($i = 0; $i < count($tags); ++$i) {
            $qs->orWhere("tags.id = :tag$i")
                ->setParameter("tag$i", $tags[$i]->getId());
        }

        return $qs
            ->orderBy("a.publishedAt", "DESC")
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Article|null
     */
    public function findOneBySlug(string $slug)
    {
        return $this->createQueryBuilder('a')
            ->andWhere("a.slug = :slug")
            ->join("a.tags", "tags")
            ->andWhere("a.publishedAt is not NULL")
            ->setParameter("slug", $slug)
//            ->setFirstResult(($page - 1) * 10)
//            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
