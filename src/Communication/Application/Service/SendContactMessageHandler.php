<?php
declare(strict_types=1);

namespace App\Communication\Application\Service;

use App\Communication\Application\Dto\ContactMessageDto;
use App\Communication\Domain\Service\MailerServiceInterface;

readonly class SendContactMessageHandler
{
    public function __construct(
        private MailerServiceInterface $mailerService,
        private EmailBuilder $emailBuilder,
    ) {
    }

    public function processContactForm(string $email, string $message): void
    {
        $contactMessageDto = new ContactMessageDto($email, $message);
        $emailDto = $this->emailBuilder->buildContactEmail($contactMessageDto);
        $this->mailerService->send($emailDto);
    }
}
