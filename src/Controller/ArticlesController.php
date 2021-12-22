<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\Tags;
use App\Form\ArticlesType;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\ArticlesRepository;
use App\Repository\TagsRepository;
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
        $getArticles = $repository->findAllDesc();
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
     * @Route ("/articles/tags/{id}", name="app_articles_index_tags")
     */
    public function indexTags(Tags $tags): Response
    {

        return $this->render('articles/show.tags.html.twig',[
            'tag'=>$tags,
            'current_menu' => 'articles',

        ]);
    }

    /**
     * @Route("/article/{id}", name="app_article_show" )
     * @param Articles $articles
     * @param Request $request
     * @return Response
     */
    public function show(Articles $articles,Request $request):Response{

dump($articles);
        return $this->render('articles/show.html.twig',[
            'article'=> $articles,
            'current_menu' => 'articles',
        ]);

    }



}