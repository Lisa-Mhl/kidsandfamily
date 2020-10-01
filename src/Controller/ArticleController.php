<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\User;
use App\Form\ArticleType;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByDate(),
        ]);
    }

    /**
 * @Route("/home-article-like/{id}", name="home_article_like")
 * @param Article $article
 * @param ArticleLikeRepository $articleLikeRepository
 * @return JsonResponse
 */
    public function getInArticle(Article $article, ArticleLikeRepository $articleLikeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if($article->isLikedByUser($user)){
            $like = $articleLikeRepository->findOneBy(['article' => $article, 'user' => $user]);
            $em->remove($like);
            $em->flush();
            return $this->json([
                'likes' => $articleLikeRepository->count(['article' => $article])
            ], 200
            );
        }

        $like = new ArticleLike();
        $like->setArticle($article)->setUser($user);
        $em->persist($like);
        $em->flush();

        return $this->json(['message' => 'Liked', 'likes' => $articleLikeRepository->count(['article' => $article])], 200);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $article->setAuthor($user);
            $article->getUpdatedAt($article);
            $article->setIsPublished(false);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_details', [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function editArticle(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');/*AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PAGE  */
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     * @param Request $request
     * @param Article $article
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, Article $article, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');/*AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PAGE  */
    }

}
