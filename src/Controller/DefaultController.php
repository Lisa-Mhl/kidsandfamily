<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository)
    {
        return $this->render('default/index.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     * @return Response
     */
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/details/{id}", name="article_details")
     * @param Article $article
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @return Response
     */
    public function articleDetails(Article $article, CommentRepository $commentRepository, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $comment->setArticle($article);
            $comment->setAuthor($user);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('home'); /* AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PARGE  */
        }
        return $this->render('default/article_details.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/articles", name="all_articles")
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function allArticles(ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('default/all_articles.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contribuer", name="contribute")
     */
    public function contribute()
    {
        return $this->render('default/contribute.html.twig');
    }

}
