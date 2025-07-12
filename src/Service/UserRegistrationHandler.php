<?php
declare(strict_types=1);

namespace App\Service;

use App\Communication\Application\MailerHandler;
use App\User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserRegistrationHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private MailerHandler $mailerService,
    ) {
    }

    public function registerUser(User $user, string $plainPassword): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $verificationToken = $this->generateVerificationToken();
        $user->setVerificationToken($verificationToken);
        $user->setEmailVerified();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->mailerService->sendEmailVerification($user->getEmail(), $verificationToken);
    }

    private function generateVerificationToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
