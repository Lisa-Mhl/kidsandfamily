<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsLetterType;
use App\Repository\LinkRepository;
use App\Repository\MoreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, MoreRepository $moreRepository,LinkRepository $linkRepository,Request $request): Response
    {
        if (!empty($this->getUser())) {
            $roles = $this->getUser()->getRoles();
            foreach($roles as $role){
                if($role === 'ROLE_USER'){
                    return $this->redirectToRoute('home');
                }
                if($role === 'ROLE_ADMIN'){
                    return $this->redirectToRoute('easyadmin');
                }
            }
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/login.html.twig', [
            'links'=>$linkRepository->findAll(),
            'mores'=> $moreRepository->findAll(),
            'last_username' => $lastUsername,
            'error' => $error,
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
