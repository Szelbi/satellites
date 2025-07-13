<?php
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?User;

    public function save(User $user, bool $flush = false): void;

    public function remove(User $user, bool $flush = false): void;
}
