<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail($to, $token)
    {
        $email = (new Email())
            ->from('noreply@example.com')
            ->to($to)
            ->subject('Подтверждение электронной почты')
            ->html('<p>Для подтверждения электронной почты, перейдите по ссылке: </p><p><a href="' . $token . '">' . $token . '</a></p>');

        $this->mailer->send($email);
    }
}