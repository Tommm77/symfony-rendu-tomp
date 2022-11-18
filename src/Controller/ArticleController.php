<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\Article1Type;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getRoles() == ["ROLE_ADMIN", "ROLE_USER"]) {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }

    #[Route('/{id}/show', name: 'app_article_showpublic', methods: ['GET'])]
    public function showpublic(Article $article, User $user): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getRoles() == ["ROLE_ADMIN", "ROLE_USER"] || $currentUser->getRoles() == ["ROLE_USER"]) {
        return $this->render('article/showpublic.html.twig', [
            'article' => $article,
        ]);
    }else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }

    #[Route('/{id}/showprofil', name: 'app_article_showprofil', methods: ['GET'])]
    public function showprofil(Article $article): Response
    {
        $currentUser = $this->getUser();
if ($currentUser->getId() == $article->getUser()->getId()) {
    return $this->render('article/showprofil.html.twig', [
        'article' => $article,
    ]);
} else {
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getRoles() == ["ROLE_ADMIN", "ROLE_USER"]) {
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }

    #[Route('/{id}/editonprofil', name: 'app_article_edit_profil', methods: ['GET', 'POST'])]
    public function editprofilarticles(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getId() == $article->getUser()->getId()) {
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_private_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/editonprofil.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }


    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getRoles() == ["ROLE_ADMIN", "ROLE_USER"]) {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }

    #[Route('/{id}/deleteprofil', name: 'app_article_deleteprofil', methods: ['POST'])]
    public function deleteatprofil(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser->getId() == $article->getUser()->getId()) {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_private_profil', [], Response::HTTP_SEE_OTHER);
    }
    else {
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
    }
}
