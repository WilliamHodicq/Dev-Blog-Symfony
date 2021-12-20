<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Config\SecurityConfig;

class ArticlesController extends AbstractController
{

    /**
     * @var ArticlesRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ArticlesRepository $repository, EntityManagerInterface $em){

        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route ("/articles", name="app_articles_index")
     */
    public function index(ArticlesRepository $repository,Request $request):Response
    {
        $getArticles = $repository->findAll();
        $newArticle = new Articles();

        $form = $this->createForm(ArticlesType::class,$newArticle );
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($newArticle );
            $this->em->flush();
            return $this->render('articles/index.html.twig',[
                "current_menu" => "articles",
                "form" => $form->createView(),
                "articles" => $getArticles,
            ]);
        }
        return $this->render('articles/index.html.twig',[
            "current_menu" => "articles",
            "form" => $form->createView(),
            "articles" => $getArticles,
        ]);
    }
    /**
     * @Route ("/articles/edit/{id}", name="app_articles_edit")
     */
    public function edit(Articles $articles,Request $request){

    }
    /**
     * @Route ("/articles{id}", name="app_articles_delete", methods="DELETE")
     */
    public function remove(Articles $articles,Request $request){

    }
}