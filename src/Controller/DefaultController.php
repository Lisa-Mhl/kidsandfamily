<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Newsletter;
use App\Entity\Report;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\NewsLetterType;
use App\Form\ReportType;
use App\Repository\AboutRepository;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ContributeRepository;
use App\Repository\HomepageRepository;
use App\Repository\LinkRepository;
use App\Repository\MoreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function index(ArticleRepository $articleRepository, HomepageRepository $homepageRepository, LinkRepository $linkRepository, MoreRepository $moreRepository, Request $request)
    {

        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('default/index.html.twig', [
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            'homepages' => $homepageRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),

        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     * @param AboutRepository $aboutRepository
     * @param Request $request
     * @return Response
     */
    public function about(AboutRepository $aboutRepository, MoreRepository $moreRepository, LinkRepository $linkRepository, Request $request)
    {

        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('default/about.html.twig', [
            'links' => $linkRepository->findAll(),
            'abouts' => $aboutRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/details/{id}", name="article_details")
     * @param Article $article
     * @param CommentRepository $commentRepository
     * @param LinkRepository $linkRepository
     * @param MoreRepository $moreRepository
     * @param Request $request
     * @return Response
     */
    public function articleDetails(Article $article, CommentRepository $commentRepository, LinkRepository $linkRepository, MoreRepository $moreRepository, Request $request): Response
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
        return $this->render('default/article_details.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'mores' => $moreRepository->findAll(),
            'links' => $linkRepository->findAll(),
            'comments' => $commentRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
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
        $article = $comment->getArticle();

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('article_details', ['id' => $article->getId()]);
    }

    /**
     * @Route("/{id}/modifier", name="comment_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Comment $comment
     * @param LinkRepository $linkRepository
     * @param MoreRepository $moreRepository
     * @return Response
     */
    public function editComment(Request $request, Comment $comment, LinkRepository $linkRepository, MoreRepository $moreRepository): Response
    {
        $article = $comment->getArticle();

        $form = $this->createForm(CommentType::class, $comment);
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

        return $this->render('default/edit_comment.html.twig', [
            'comment' => $comment,
            'links' => $linkRepository->findAll(),
            'form' => $form->createView(),
            'mores' => $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/signaler/{id}", name="report")
     * @param Article $article
     * @param Request $request
     * @param Mailer $mailer
     * @return Response
     */
    public function report(Article $article, Request $request, Mailer $mailer, MoreRepository $moreRepository, LinkRepository $linkRepository)
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
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
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
    public function reportComment(Comment $comment, Request $request, Mailer $mailer, MoreRepository $moreRepository, LinkRepository $linkRepository)
    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

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
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'form' => $form->createView(),
            'formNewsLetter' => $formNewsLetter->createView(),

        ]);
    }

    /**
     * @Route("/publications", name="all_articles")
     * @param Request $request
     * @return Response
     */

    public function allArticles(ArticleRepository $articleRepository, LinkRepository $linkRepository, MoreRepository $moreRepository, CategoryRepository $categoryRepository, Request $request)

    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('default/all_articles.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'links' => $linkRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/contribuer", name="contribute")
     * @param ContributeRepository $contributeRepository
     * @param Request $request
     * @return Response
     */
    public function contribute(ContributeRepository $contributeRepository, LinkRepository $linkRepository, MoreRepository $moreRepository, Request $request)
    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('default/contribute.html.twig', [
            'contributes' => $contributeRepository->findAll(),
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Mailer $mailer, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
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
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/politics", name="politics")
     */
    public function politics(MoreRepository $moreRepository, LinkRepository $linkRepository, Request $request)
    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('default/politics.html.twig', [
            'links' => $linkRepository->findAll(),
            'mores' => $moreRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
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
     * @param MoreRepository $moreRepository
     * @param LinkRepository $linkRepository
     * @param $request
     * @return RedirectResponse|Response
     */
    public function reportThanks(MoreRepository $moreRepository, LinkRepository $linkRepository, Request $request)
    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

            return $this->render('default/report_thanks.html.twig', [
            'mores' => $moreRepository->findAll(),
            'links' => $linkRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
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
     * @Route("/all-article-like/{id}", name="all_article_like")
     * @param Article $article
     * @param ArticleLikeRepository $articleLikeRepository
     * @return JsonResponse
     */
    public function getInAllArticle(Article $article, ArticleLikeRepository $articleLikeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($article->isLikedByUser($user)) {
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
     * @Route("/articles-js", name = "articles-js")
     *
     */
    public function articlesForJs(ArticleRepository $articleRepository)
    {
        return $this->json($articleRepository->findAll(), 200, [], ['groups' => 'article']);
    }


    /**
     * @Route("/aide", name="help")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function help(Request $request)
    {
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('article/help.html.twig',
            ['formNewsLetter' => $formNewsLetter->createView(),
            ]);
    }

}
