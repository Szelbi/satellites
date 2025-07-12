<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

interface EntityInterface
{
    public function getId();

    public function __toString(): string;

//    public static function getSelfName(): string;
}
