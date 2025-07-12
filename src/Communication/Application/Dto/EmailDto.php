<?php
declare(strict_types=1);

namespace App\Communication\Application\Dto;

readonly class EmailDto
{
    public function __construct(
        public string $from,
        public string $to,
        public string $subject,
        public string $htmlContent,
    ) {
    }
}