<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicProfilController extends AbstractController
{
    #[Route('/public/profil', name: 'app_public_profil')]
    public function index(ArticleRepository $articleRepository, UserRepository $userRepository): Response
    {
        return $this->render('public_profil/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }
}
