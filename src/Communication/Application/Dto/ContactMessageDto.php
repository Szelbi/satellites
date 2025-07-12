<?php
declare(strict_types=1);

namespace App\Communication\Application\Dto;

readonly class ContactMessageDto
{
    public function __construct(
        public string $fromEmail,
        public string $messageContent,
    ) {
    }
}