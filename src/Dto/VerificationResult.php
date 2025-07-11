<?php
declare(strict_types=1);

namespace App\Dto;

readonly class VerificationResult
{
    public function __construct(
        public bool $success,
        public string $message,
        public string $type = 'error'
    ) {
    }
}
