<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\NewsLetterType;
use App\Form\UserType;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use App\Repository\MoreRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/profil")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/{id}", name="profile", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function profile(User $user, MoreRepository $moreRepository,LinkRepository $linkRepository): Response
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param $moreRepository
     * @return Response
     */
    public function new(Request $request, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param $moreRepository
     * @return Response
     */
    public function edit(Request $request, User $user, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
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

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
            'form' => $form->createView(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $session = new Session();
            $session->invalidate();

            $this->addFlash('sup', 'Votre compte a bien été supprimé');
        }

        return $this->redirectToRoute('app_logout');
    }

    /**
     * @Route("/{id}/hobbies", name="hobbies", methods={"GET","POST"})
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function hobbies(User $user, MoreRepository $moreRepository,LinkRepository $linkRepository,Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }
        return $this->render('user/hobbies.html.twig', [
            'user' => $user,
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/mes_publications", name = "my_articles", methods = {"GET"})
     * @param User $user
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function showMyArticles(User $user, ArticleRepository $articleRepository,LinkRepository $linkRepository,CategoryRepository $categoryRepository, MoreRepository $moreRepository): Response
    {
        return $this->render('user/my_articles.html.twig', [
            'user' => $user,
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
            'articles' => $articleRepository->findBy(['author'=>$user]),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/mes_coordonnees", name = "my_address", methods = {"GET"})
     *
     * @param User $user
     * * @return Response
     */
    public function showMyAddress(User $user, MoreRepository $moreRepository, LinkRepository $linkRepository): Response
    {
        return $this->render('user/address.html.twig', [
            'user' => $user,
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/categories", name = "categories", methods = {"GET"})
     *
     * @param User $user
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function showCategories(User $user, CategoryRepository $categoryRepository,LinkRepository $linkRepository,MoreRepository $moreRepository): Response
    {
        return $this->render('user/categories.html.twig', [
            'user' => $user,
            'mores'=> $moreRepository->findAll(),
            'links'=>$linkRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/my-article-like/{id}", name="my_article_like")
     * @param Article $article
     * @param ArticleLikeRepository $articleLikeRepository
     * @return JsonResponse
     */
    public function getInMyArticle(Article $article, ArticleLikeRepository $articleLikeRepository)
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

