<?php
declare(strict_types=1);

namespace App\Todo\Infrastructure\Repository;

use App\Todo\Domain\Entity\Todo;
use App\Todo\Domain\Repository\TodoRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TodoRepository extends ServiceEntityRepository implements TodoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    /**
     * @return Todo[]
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findById(int $id): ?Todo
    {
        return parent::find($id);
    }

    public function save(Todo $todo): void
    {
        $this->getEntityManager()->persist($todo);
        $this->getEntityManager()->flush();
    }

    public function remove(Todo $todo): void
    {
        $this->getEntityManager()->remove($todo);
        $this->getEntityManager()->flush();
    }
}
