<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivateProfilController extends AbstractController
{
    #[Route('/private/profil', name: 'app_private_profil')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('private_profil/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
}
