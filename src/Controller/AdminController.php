<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactAdminType;
use App\Repository\NewsletterRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/email_contact/{id}", name="email_contact")
     * @param Request $request
     * @param Contact $contact
     * @param Mailer $mailer
     * @return Response
     */
    public function sendEmailContact(Request $request, Contact $contact, Mailer $mailer): Response
    {
        $form = $this->createForm(ContactAdminType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mailer->adminContactEmail($contact);

            return $this->redirectToRoute('easyadmin', ['entity' => 'Contact']);
        }

        return $this->render('admin/contact_mail.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/newsletter_email", name="newsletter_email")
     * @param NewsletterRepository $newsletterRepository
     * @return Response
     */
    public function getNewsLetterEmails(NewsletterRepository $newsletterRepository)
    {
        # GET ALL THE EMAIL ON A BLANK PAGE FOR NEWSLETTER IN EASY-ADMIN #
        return $this->render('admin/newsletter_email.html.twig', [
            'newsletters' => $newsletterRepository->findAll(),
        ]);
    }
}
