<?php


namespace App\Controller;


use App\Repository\Magazine\InfoFlashRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
//    /**
//     * @var EntityManagerInterface $em
//     */
//    private $em;
//    use BaseControllerTrait;

//    /**
//     * HomeController constructor.
//     * @param EntityManagerInterface $em
//     */
//    public function __construct(EntityManagerInterface $em)
//    {
//        $this->em = $em;
//    }
//

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(InfoFlashRepository $repo)
    {
        $infos = $repo->findPublished();
        return $this->render("index.html.twig", [
            "flashInfos" => $infos
        ]);
    }
}