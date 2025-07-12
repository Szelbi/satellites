<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity\Trait;

use ReflectionClass;

trait PropertiesTrait
{
    public static function getPropertyNames(bool $skipId = true): array
    {
        $vars = (new ReflectionClass(self::class))->getProperties();

        if ($skipId) {
            $vars = array_filter($vars, fn($var) => $var->getName() !== 'id');
        }

        return array_map(fn($var) => $var->getName(), $vars);
    }
}
