<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;


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
}
