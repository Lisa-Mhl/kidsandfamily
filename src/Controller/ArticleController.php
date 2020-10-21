<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Newsletter;
use App\Entity\Report;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\NewsLetterType;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use App\Repository\LinkRepository;
use App\Repository\MoreRepository;
use App\Repository\ReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/publication")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/publications-Index", name="article_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
            'articles' => $articleRepository->findAll(),

        ]);
    }

    /**
     * @Route("/ajouter", name="article_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
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

        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     * @param Article $article
     * @return Response
     */
    public function show(Article $article, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function editArticle(Request $request, Article $article, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_details', ['id' => $article->getId()]);
        }

        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }


    /**
     * @Route("/{id<\d+>}", name="article_delete", methods={"DELETE"})
     * @param Request $request
     * @param $article
     * @return Response
     */
    public function delete(Request $request, Article $article): Response
    {
        ;
       $user = $article ->getAuthor();
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

    }
        return $this->redirectToRoute('my_articles', ['id' => $user->getId()]);
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

}
