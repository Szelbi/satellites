<?php
declare(strict_types=1);

namespace App\Communication\Application\Dto;

readonly class EmailVerificationDto
{
    public function __construct(
        public string $toEmail,
        public string $verificationToken,
    ) {
    }
}