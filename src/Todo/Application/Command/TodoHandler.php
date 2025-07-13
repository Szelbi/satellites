<?php
declare(strict_types=1);

namespace App\Todo\Application\Command;

use App\Todo\Domain\Entity\Todo;
use App\Todo\Domain\Repository\TodoRepositoryInterface;

readonly class TodoHandler
{
    public function __construct(
        private TodoRepositoryInterface $repository
    ) {
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): ?Todo
    {
        return $this->repository->findById($id);
    }

    public function save(Todo $todo): void
    {
        $this->repository->save($todo);
    }

    public function remove(Todo $todo): void
    {
        $this->repository->remove($todo);
    }
}
