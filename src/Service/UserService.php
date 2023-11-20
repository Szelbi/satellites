<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        public UserRepository $userRepository,
        public UserPasswordHasherInterface $passwordHasher,
        public ValidatorInterface $validator,
    ) {
    }

    public function createUser(string $email, string $password): bool
    {
        $newUser = new User();
        $password = $this->passwordHasher->hashPassword($newUser, $password);

        $newUser->setEmail($email);
        $newUser->setPassword($password);

        $errors = $this->validator->validate($newUser);

        if (count($errors) > 0) {
            return false;
        }

        $this->userRepository->save($newUser, true);
        return true;
    }
}
