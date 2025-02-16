<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

readonly class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig
    ) {
    }

    public function sendContactMessage(string $fromEmail, string $messageContent): void
    {
        $email = (new Email())
            ->from($fromEmail)
            ->to('example@mail.com')
            ->subject('New Contact Form Submission')
            ->html($this->twig->render('emails/contact.html.twig', [
                'email' => $fromEmail,
                'message' => $messageContent,
            ]));

        $this->mailer->send($email);
    }
}
