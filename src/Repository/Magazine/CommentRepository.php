<?php

namespace App\Repository\Magazine;

use App\Entity\Magazine\Article;
use App\Entity\Magazine\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @param Article $article
     * @return Comment[]
     */
    public function findParentComments(Article $article)
    {
//        $dql = "SELECT c FROM Acme\Company c";
//        $query = $entityManager->createQuery($dql);
//        $companies = $query->getResult();
//
//        $employees = $entityManager
//            ->getRepository('Acme\Employee')
//            ->findBy(array('company' => $companies));
//
//        $employeesByCompany = [];
//        foreach ($employees as $employee) {
//            $companyId = $employee->getCompany()->getId();
//            $employeesByCompany[$companyId][] = $employee;
//        }

        $comments = $this->createQueryBuilder('c')
            ->andWhere('c.article = :article')
            ->setParameter("article", $article)
            ->orderBy('c.createdAt', 'DESC')
            ->andWhere('c.parent IS NULL')
            ->getQuery()
            ->getResult();

        $replies = $this->findBy(['parent' => $comments], ["createdAt" => "DESC"]);

        // return comment & replies
        foreach ($replies as $reply) {
            $reply->getParent()->addReply($reply);
//            $reply->setArticle($reply->getParent()->getArticle());
//            $employeesByCompany[$companyId][] = $employee;
        }
//        $this->getEntityManager()->getReference()

        return $comments;
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.article = :article')
//            ->setParameter("article", $article)
//            ->leftJoin('c.replies', "replies")
//            ->orderBy('c.createdAt', 'DESC')
////            ->setMaxResults(10)
//            ->andWhere('c.parent IS NULL')
//            ->getQuery()
//            ->getResult();
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
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
    public function findOneBySomeField($value): ?Comment
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
