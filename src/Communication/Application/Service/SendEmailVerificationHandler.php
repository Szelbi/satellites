<?php
declare(strict_types=1);

namespace App\Communication\Application\Service;

use App\Communication\Application\Dto\EmailVerificationDto;
use App\Communication\Domain\Service\MailerServiceInterface;

readonly class SendEmailVerificationHandler
{
    public function __construct(
        private MailerServiceInterface $mailerService,
        private EmailBuilder $emailBuilder,
    ) {
    }

    public function sendEmailVerification(string $toEmail, string $verificationToken): void
    {
        $verificationDto = new EmailVerificationDto($toEmail, $verificationToken);
        $emailDto = $this->emailBuilder->buildVerificationEmail($verificationDto);
        $this->mailerService->send($emailDto);
    }
}