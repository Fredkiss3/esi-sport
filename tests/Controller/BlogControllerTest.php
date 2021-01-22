<?php

namespace App\Tests\Controller;

use App\Entity\Magazine\Article;
use App\Entity\Magazine\Comment;
use App\Entity\Magazine\InfoFlash;
use App\Entity\Magazine\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Lorem;
use Faker\Provider\Text;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends BaseControllerTest
{

    /**
     * @var array|Article[]|InfoFlash[]
     */
    protected $entities = [];

    /**
     * @var string[]
     */
    protected $fixturePath;

    /**
     * BlogTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->fixturePath = [dirname(dirname(__DIR__)) . "/fixtures/BlogFixtures.yml"];
    }

    public function testBlogDetail()
    {
        $client = static::createClient();
        $this->getFixtures();
        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];

        $related = $em->getRepository(Article::class)->findRelatedByTags($article->getTags(), $article->getId());

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", $article->getTitle(),
            "Blog Detail should show the article title");

        $this->assertSelectorTextContains(".sportsmagazine-rich-editor>article", $article->getContent());

        $this->assertSame(count($article->getTags()), $crawler->filter(".sportsmagazine-tags>a")->count(),
            "Blog Detail should show all tags for the article"
        );

        $this->assertLessThanOrEqual(count($related), $crawler->filter(".sportsmagazine-article-text>h5")->count(),
            "Blog Detail should show all related articles"
        );
    }

    public function testBlogDetailShowAllTags()
    {
        $client = static::createClient();
        $this->getFixtures();
        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $tags = $em->getRepository(Tag::class)->findWithArticleCount();
        $count = count($tags);

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());


        $this->assertResponseIsSuccessful();

        $this->assertSame(1, $crawler->filter(".sportsmagazine-widget-heading h2")->count(),
            "Show only Tags");

        $this->assertSelectorTextContains(".sportsmagazine-widget-heading h2", "Mot-clés",
            "Show Tag Title");

        $this->assertSame($count, $crawler->filter(".widget.widget_cetagories>ul>li")->count(),
            "Should show all tags");
    }

    public function testBlogIndex()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $articles = $em->getRepository(Article::class)->searchByTitle("");
        $tags = $em->getRepository(Tag::class)->findWithArticleCount();
        $count = count($tags);

        $crawler = $client->request('GET', '/blog/');

        $this->assertResponseIsSuccessful();

        $this->assertSame(1, $crawler->filter(".sportsmagazine-widget-heading h2")->count(),
            "Show only Tags");

        $this->assertSelectorTextContains(".sportsmagazine-widget-heading h2", "Mot-clés",
            "Show Tag Title");

        $this->assertSame($count, $crawler->filter(".widget.widget_cetagories>ul>li")->count(),
            "Should show all tags");

        $this->assertSame(count($articles), $crawler->filter(".sportsmagazine-link-btn")->count(),
            "Only the 10th first articles should be shown");
    }

    public function testPagination()
    {
        // TODO
        self::assertSame(1, 1, "TODO");
//        $client = static::createClient();
//        $this->getFixtures();
    }

    public function testInfoFlashShowingOnHome()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(InfoFlash::class)->findPublished();

        $count = count($data);

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertLessThanOrEQual($count, $crawler->filter(".sportsmagazine-ticker-slide-text")
            ->count(), "Only Flash Infos should show");

        for ($i = 0; $i < $count; $i++) {
            $this->assertSelectorTextContains('.sportsmagazine-ticker-slide-text#' . $data[$i]->getId(), $data[$i]->getContent()
                , "Flash Infos should be shown");
        }
    }

    public function testBlogSearchWithTags()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Article::class)->searchByTag("tag1");

        $count = count($data);

        $crawler = $client->request('GET', '/blog/tags/tag1');

        $this->assertResponseIsSuccessful();
        $this->assertLessThanOrEqual($count, $crawler->filter(".sportsmagazine-article-text>h5")
            ->count(), "Only published articles should be Shown");
    }

    public function testBlogSearchWithQueryStringShowOnlyPublishedArticles()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Article::class)->searchByTitle("title");

        $count = count($data);

        $crawler = $client->request('GET', '/blog/search?q=title');

        $this->assertResponseIsSuccessful();

        $this->assertLessThanOrEQual($count, $crawler->filter(".sportsmagazine-article-text>h5")
            ->count(), "Only published articles should be Shown");


    }

    public function testBlogDetailShowCommentTotalOnHeader()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];
        $count = count($article->getComments());

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("ul.sportsmagazine-thumb-option li:nth-child(2)", $count);
    }

    public function testBlogDetailShowAllComments()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];
        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Comment::class)->findBy(["article" => $article]);

        $count = count($data);

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());

        $this->assertResponseIsSuccessful();
        $this->assertSame($count, $crawler->filter(".thumb-list")->count(),
            "Should Show all Comments");
    }

    public function testShowCommentReplyForms()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Comment::class)->findParentComments($article);

        $count = count($data);

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());

        $this->assertResponseIsSuccessful();
        $this->assertSame($count, $crawler->filter("form.collapse.multi-collapse")->count(),
            "Should Show all Comments");
    }

    public function testMakeComment()
    {
        $client = static::createClient();
        $this->getFixtures();

        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Comment::class)->findParentComments($article);

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());
        $form = $crawler->filter("input[value='Soumettre']")->form(["comment_form" =>
            [
                "author" => "Author1",
                "content" => Lorem::text(),
                "article" => $data[0]->getArticle()->getId(),
            ]]);

        $client->submit($form);

        $this->assertResponseRedirects('/blog/' . $article->getSlug(), 302, "Should redirect to detail");
        $crawler = $client->followRedirect();

        $this->assertSame(count($data) + 1, $crawler->filter("form.collapse.multi-collapse")->count(),
            "Should Show the added Comment");
    }

    public function testReplyComment()
    {
        $client = static::createClient();
        $this->getFixtures();

        // $crawler->filter("form.collapse.multi-collapse")->
        /**
         * @var Article $article
         */
        $article = $this->entities["article1"];

        /**
         * @var EntityManagerInterface $em
         */
        $em = $client->getContainer()->get("doctrine")->getManager();
        $data = $em->getRepository(Comment::class)->findParentComments($article);
        $all = $em->getRepository(Comment::class)->findBy(["article" => $article]);

        $crawler = $client->request('GET', '/blog/' . $article->getSlug());
        $form = $crawler->filter("input[value='Répondre']")->form(["comment_form" =>
            [
                "author" => "Author1",
                "content" => Lorem::text(),
            ]]);

        $client->submit($form);


        $this->assertResponseRedirects('/blog/' . $article->getSlug(), 302, "Should redirect to detail");
        $crawler = $client->followRedirect();

        $this->assertSame(count($data), $crawler->filter("form.collapse.multi-collapse")->count(),
            "Should not show the reply in comments");

        $this->assertSame(count($all) + 1, $crawler->filter(".thumb-list")->count(),
            "Should Show all Comments");
    }

    public function testCannotMakeCommentToChildren()
    {
        // TODO
        self::assertSame(1, 1, "TODO");
    }
}
