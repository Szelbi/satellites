<?php

namespace App\Shared\Application\Dto;

readonly class MenuItemDto
{
    public function __construct(
        public string $route,
        public string $translationKey,
        public string $icon,
    ) {
    }
}
