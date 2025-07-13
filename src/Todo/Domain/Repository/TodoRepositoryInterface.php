<?php
declare(strict_types=1);

namespace App\Todo\Domain\Repository;

use App\Todo\Domain\Entity\Todo;

interface TodoRepositoryInterface
{
    /**
     * @return Todo[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Todo;

    public function save(Todo $todo): void;

    public function remove(Todo $todo): void;
}
