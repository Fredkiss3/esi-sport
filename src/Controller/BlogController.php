<?php


namespace App\Controller;


use App\Entity\Magazine\Article;
use App\Entity\Magazine\Comment;
use App\Form\CommentFormType;
use App\Repository\Magazine\ArticleRepository;
use App\Repository\Magazine\CommentRepository;
use App\Repository\Magazine\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    use BaseControllerTrait;

    /**
     * @Route("/", name="blog.index", methods={"GET"})
     */
    public function index(ArticleRepository $repo, TagRepository $tagRepository): Response
    {
        $articles = $repo->searchByTitle("");
        $tags = $tagRepository->findWithArticleCount();

        return $this->render("blog/index.html.twig", [
            "articles" => $articles,
            "tags" => $tags,
        ]);
    }

    /**
     * @Route("/tags/{tag}", name="blog.tag", methods={"GET"})
     */
    public function tag(string $tag, Request $request, ArticleRepository $repo): Response
    {
        $qs = $request->get("q", "");
        $results = $repo->searchByTag($tag, $qs);
        return $this->render("blog/search.html.twig", [
            "results" => $results,
            "query" => $qs
        ]);
    }

    /**
     * @Route("/search", name="blog.search", methods={"GET"})
     */
    public function search(Request $request, ArticleRepository $repo): Response
    {
        $qs = $request->get("q", "");
        $results = $repo->searchByTitle($qs);
//        dd($results);
        return $this->render("blog/search.html.twig", [
            "results" => $results,
            "query" => $qs
        ]);

    }

    /**
     * @Route("/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}/comment/make", name="comment.make", methods={"POST"})
     */
    public function makeComment(string $slug, Request $request, EntityManagerInterface $em, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBySlug($slug);


        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Comment $comment
             */
            $comment = $form->getData();

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('blog.detail', ["slug" => $article->getSlug()]);
        }

        $this->addFlash("error", "Formulaire mal rempli");
        return $this->redirectToRoute('blog.detail', ["slug" => $article->getSlug()],
            301);
    }

    /**
     * @Route("/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}", name="blog.detail", methods={"GET"})
     * @throws NotFoundHttpException
     */
    public function detail(string $slug, ArticleRepository $repo, TagRepository $tagRepository, CommentRepository $commentRepository): Response
    {
        $article = $repo->findOneBySlug($slug);
        $related = $repo->findRelatedByTags($article->getTags(), $article->getId());
        $tags = $tagRepository->findWithArticleCount();
        $comments = $commentRepository->findParentComments($article);

//        if(is_null($article)) {
//            throw $this->createNotFoundException('The article requested does not exists');
//        }
//
        $form = $this->createForm(CommentFormType::class, null);

        return $this->render("blog/detail.html.twig", [
            "article" => $article,
            "related" => $related,
            "tags" => $tags,
            "comments" => $comments,
            "formView" => $form->createView()
        ]);
    }

}