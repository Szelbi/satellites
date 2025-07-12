<?php
declare(strict_types=1);

namespace App\Communication\Application\Service;

use App\Communication\Application\Dto\ContactMessageDto;
use App\Communication\Application\Dto\EmailDto;
use App\Communication\Application\Dto\EmailVerificationDto;
use Twig\Environment;

readonly class EmailBuilder
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    public function buildContactEmail(ContactMessageDto $contactMessage): EmailDto
    {
        $htmlContent = $this->twig->render('emails/contact.html.twig', [
            'email' => $contactMessage->fromEmail,
            'message' => $contactMessage->messageContent,
        ]);

        return new EmailDto(
            from: $contactMessage->fromEmail,
            to: 'dawidgos25@gmail.com',
            subject: 'New Contact Form Submission',
            htmlContent: $htmlContent,
        );
    }

    public function buildVerificationEmail(EmailVerificationDto $verification): EmailDto
    {
        $verificationUrl = sprintf(
            '%s/verify-email?token=%s',
            $_ENV['APP_URL'] ?? 'http://localhost:8001',
            $verification->verificationToken
        );

        $htmlContent = $this->twig->render('emails/verification.html.twig', [
            'verification_url' => $verificationUrl,
        ]);

        return new EmailDto(
            from: 'dawid.sender@gmail.com',
            to: $verification->toEmail,
            subject: 'Potwierdź swój email',
            htmlContent: $htmlContent,
        );
    }
}