<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer {
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $token)
    {
      //  $user = new User();
        $email = (new TemplatedEmail())
            ->from('nabousoum@brasilburger.sn')
            ->to(new Address($email))
            ->subject('BRASIL BURGER: activez votre compte pour profiter des meilleurs burgers de dakar')

            // path of the Twig template to render
            ->htmlTemplate('mailer/index.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'token' => $token,
                'expiration_date' => new \DateTime('+2 minutes'),
            ])
        ;

        $this->mailer->send($email);
    }
}