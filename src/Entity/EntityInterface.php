<?php

declare(strict_types=1);

namespace App\Entity;

interface EntityInterface
{
    public function getId();

    public function __toString(): string;

//    public static function getSelfName(): string;
}
