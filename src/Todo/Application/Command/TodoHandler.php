<?php
declare(strict_types=1);

namespace App\Todo\Application\Command;

use App\Service\Trait\TransactionalMakeTrait;
use App\Service\TransactionalMakeInterface;
use App\Todo\Domain\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TodoHandler implements TransactionalMakeInterface
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
