<?php
declare(strict_types=1);

namespace App\Communication\Application\Service;

use App\Communication\Application\MailerService;

readonly class SendContactMessageHandler
{
    public function __construct(
        private MailerService $mailerHandler,
    ) {
    }

    public function processContactForm(string $email, string $message): void
    {
        $this->mailerHandler->sendContactMessage($email, $message);
    }
}
