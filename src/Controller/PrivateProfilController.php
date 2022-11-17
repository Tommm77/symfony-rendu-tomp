<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivateProfilController extends AbstractController
{
    #[Route('/private/profil', name: 'app_private_profil')]
    public function index(): Response
    {
        return $this->render('private_profil/index.html.twig', [
            'controller_name' => 'PrivateProfilController',
        ]);
    }
}
