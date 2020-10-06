<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;


class Mailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var ParameterBagInterface
     */
    private $param;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $param) {
        $this->mailer = $mailer;
        $this->param = $param;
    }

    public function notifEmailClient($entity)
    {
        $email = (new TemplatedEmail())
            ->from($this->param->get('mailer_from'))
            ->to($entity->getEmail())
            ->subject("Votre message a bien été envoyé !")
            ->htmlTemplate('emails/notification.html.twig')
            ->context([
                'contact' => $entity,
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
    }

    public function notifEmailAdmin($entity)
    {
        $email = (new TemplatedEmail())
            ->from(new Address ($this->param->get('mailer_from'), "Kids & Family"))
            ->to($this->param->get('mailer_from'))
            ->subject("Quelqu'un vous a contacté")
            ->htmlTemplate('emails/notification_admin.html.twig')
            ->context([
                'contact' => $entity,
            ]);

        $this->mailer->send($email);
    }


    public function notifReport($entity)
    {
        $email = (new TemplatedEmail())
            ->from(new Address ($this->param->get('mailer_from'), "Kids & Family"))
            ->to($this->param->get('mailer_from'))
            ->subject("Une publication a été signalée")
            ->htmlTemplate('emails/report_notification.html.twig')
            ->context([
                'report' => $entity,
                'article' => $entity,
            ]);

        $this->mailer->send($email);
    }
    public function notifReportCom($entity)
    {
        $email = (new TemplatedEmail())
            ->from(new Address ($this->param->get('mailer_from'), "Kids & Family"))
            ->to($this->param->get('mailer_from'))
            ->subject("Un commentaire a été signalé")
            ->htmlTemplate('emails/report_comment_notification.html.twig')
            ->context([
                'report' => $entity,
                'comment' => $entity,
            ]);

        $this->mailer->send($email);
    }

    public function adminContactEmail($entity)
    {
        $email = (new TemplatedEmail())
            ->from(new Address ($this->param->get('mailer_from'), "Kids & Family"))
            ->to($entity->getEmail())
            ->subject("Réponse suite à votre demande")
            ->htmlTemplate('emails/contact_email.html.twig')
            ->context([
                'contact' => $entity,
            ]);

        $this->mailer->send($email);
    }

}
