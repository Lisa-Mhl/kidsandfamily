<?php

namespace App\Controller;

use App\Entity\ArticleLike;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Report;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\ReportType;
use App\Repository\AboutRepository;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ContributeRepository;
use App\Repository\HomepageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, HomepageRepository $homepageRepository)
    {
        return $this->render('default/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'homepages' => $homepageRepository->findAll(),

        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     * @return Response
     */
    public function about(AboutRepository $aboutRepository)
    {
        return $this->render('default/about.html.twig', [
            'abouts' => $aboutRepository->findAll(),
        ]);
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
            return $this->redirectToRoute('home');/* AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PARGE  */
        }
        return $this->render('default/article_details.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('home');/* AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PAGE  */
    }

    /**
     * @Route("/{id}/modifier", name="comment_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Comment $comment
     * @param $article
     * @return Response
     */
    public function editComment(Request $request, Comment $comment,Article $article): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');/* AJOUTER REDICRECTION SUR LA MEME PAGE AVEC RECHARGEMENT PAGE  */
        }

        return $this->render('default/edit_comment.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/signaler/{id}", name="report")
     * @param Article $article
     * @param Request $request
     * @param Mailer $mailer
     * @return Response
     */
    public function report(Article $article, Request $request, Mailer $mailer)
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $report->setEmail($user);
            $report->setArticle($article);
            $report->setCreatedAt(new \DateTime());
            $entityManager->persist($report);
            $entityManager->flush();

            $mailer->notifReport($report);

            return $this->redirectToRoute('report_thanks');
        }
        return $this->render('default/report.html.twig', [
            'article' => $article,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/signaler_commentaire/{id}", name="report_comment")
     * @param Comment $comment
     * @param Request $request
     * @param Mailer $mailer
     * @return Response
     */
    public function reportComment(Comment $comment, Request $request, Mailer $mailer)
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $report->setEmail($user);
            $report->setComment($comment);
            $report->setCreatedAt(new \DateTime());
            $entityManager->persist($report);
            $entityManager->flush();

            $mailer->notifReportCom($report);

            return $this->redirectToRoute('report_thanks');
        }
        return $this->render('default/report_comment.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),

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
     * @Route("/all-article-like/{id}", name="all_article_like")
     * @param Article $article
     * @param ArticleLikeRepository $articleLikeRepository
     * @return JsonResponse
     */
    public function getInAllArticle(Article $article, ArticleLikeRepository $articleLikeRepository)
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
     * @Route("/contribuer", name="contribute")
     * @param ContributeRepository $contributeRepository
     * @return Response
     */
    public function contribute(ContributeRepository $contributeRepository)
    {
        return $this->render('default/contribute.html.twig', [
            'contributes' => $contributeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();

            $mailer->notifEmailClient($contact);

            $mailer->notifEmailAdmin($contact);

            return $this->redirectToRoute('merci');
        }

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/merci", name="merci")
     */
    public function thanks()
    {
        return $this->render('default/thanks.html.twig');
    }

    /**
     * @Route("/signalement", name="report_thanks")
     */
    public function reportThanks()
    {
        return $this->render('default/report_thanks.html.twig');
    }

    /**
     * @Route("/map", name = "map")
     *
     */
    public function showMap(ArticleRepository $articleRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('default/map.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),

        ]);
    }

    /**
     * @Route("/articles-js", name = "articles-js")
     *
     */
    public function articlesForJs(ArticleRepository $articleRepository)
    {
        return $this->json($articleRepository->findAll(), 200, [], ['groups' => 'article']);
    }

}
