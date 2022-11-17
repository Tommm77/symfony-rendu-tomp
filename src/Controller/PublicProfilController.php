<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicProfilController extends AbstractController
{
    #[Route('/public/profil', name: 'app_public_profil')]
    public function index(): Response
    {
        return $this->render('public_profil/index.html.twig', [
            'controller_name' => 'PublicProfilController',
        ]);
    }
}
