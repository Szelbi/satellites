<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity\Trait;

use ReflectionClass;

trait SelfNameTrait
{
    public static function getSelfName(): string
    {
        return (new ReflectionClass(self::class))->getShortName();
    }
}
