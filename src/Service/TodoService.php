<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Todo;
use App\Service\Trait\TransactionalMakeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TodoService implements TransactionalMakeInterface
{
    use TransactionalMakeTrait;

    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Todo::class);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): ?Todo
    {
        return $this->repository->find($id);
    }

    public function make($model): EntityManagerInterface
    {
        $this->em->persist($model);

        return $this->em;
    }
}
