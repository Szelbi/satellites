<?php
declare(strict_types=1);

namespace App\Communication\Application;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

readonly class MailerHandler
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig,
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

    public function sendEmailVerification(string $toEmail, string $verificationToken): void
    {
        $verificationUrl = sprintf(
            '%s/verify-email?token=%s',
            $_ENV['APP_URL'] ?? 'http://localhost:8001',
            $verificationToken
        );

        $email = (new Email())
            ->from('dawid.sender@gmail.com')
            ->to($toEmail)
            ->subject('Potwierdź swój email')
            ->html($this->twig->render('emails/verification.html.twig', [
                'verification_url' => $verificationUrl,
            ]));

        $this->mailer->send($email);
    }
}
