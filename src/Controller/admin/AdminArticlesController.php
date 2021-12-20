<?php

namespace App\Controller\admin;


use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class AdminArticlesController extends AbstractController
{


    /**
     * @var ArticlesRepository
     */
    private $repository;

    public function __construct(ArticlesRepository $repository, EntityManagerInterface $em){


        $this->em = $em;
        $this->repository = $repository;
    }



    /**
     * @Route("/", name="app_admin_index", methods={"GET"})
     */
    public function index(): Response
    {
        $articles = $this->repository->findAll();

        return $this->render('admin/index.html.twig', [
            'articles' => $articles,
            "current_menu" => "admin",
        ]);
    }

    /**
     * @route ("/admin/create", name="app_admin_new")
     */
    public function new(Request $request){

        $article = new Articles();
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($article);
            $this->em->flush();

            $this->addFlash('success','Cet article a été créer avec succès');
            return $this->redirectToRoute('app_admin_index');
        }

        return $this->render('admin/new.html.twig',[
            'article' =>$article,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/edit/{id}", name="app_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,  EntityManagerInterface $entityManager,Articles $articles): Response
    {

        $form = $this->createForm(ArticlesType::class,$articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Cet article a été modifier avec succès');
            return $this->redirectToRoute('app_admin_index');
        }

        return $this->render('admin/edit.html.twig',[
            'article' =>$articles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $articles): Response
    { if ($this->isCsrfTokenValid('delete'. $articles->getId(),$request->get('_token'))){
        $this->em->remove($articles);
        $this->em->flush();
        $this->addFlash('success','Ce bien a été supprimer');
    }
        return $this->redirectToRoute('app_admin_index');

    }

}