<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ContributeRepository;
use App\Repository\HomepageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            'homepages' =>$homepageRepository->findAll(),
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
     * @param ContributeRepository $contributeRepository
     * @return Response
     */
    public function contribute(ContributeRepository $contributeRepository)
    {
        return $this->render('default/contribute.html.twig',[
            'contributes'=>$contributeRepository->findAll(),
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            #TO DO : AJOUTER NOTIFICATION / CONFIRMATION
            return $this->redirectToRoute('merci');
        }

        return $this->render('default/contact.html.twig', [
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/merci", name="merci")
     */
    public function thanks()
    {
        return $this->render('default/thanks.html.twig');
    }


}
