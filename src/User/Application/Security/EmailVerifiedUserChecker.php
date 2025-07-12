<?php

namespace App\User\Application\Security;

use App\User\Domain\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailVerifiedUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isEmailVerified()) {
            throw new CustomUserMessageAccountStatusException('Twój email nie został jeszcze potwierdzony. Sprawdź swoją skrzynkę mailową.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
