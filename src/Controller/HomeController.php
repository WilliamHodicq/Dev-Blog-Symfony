<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route ("/", name="app_homepage")
     */
    public function homepage(ArticlesRepository $repository): Response
    {
        $articles = $repository->findLatest();
        return $this->render('pages/home.html.twig',[
            "current_menu" => "home",
            'articles'=>$articles,
        ]);
    }
}