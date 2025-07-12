<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\VerificationResult;
use App\User\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class EmailVerificationService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function verifyEmailToken(string $token): VerificationResult
    {
        if (empty($token)) {
            return new VerificationResult(false, 'Nieprawidłowy link weryfikacyjny.');
        }

        $user = $this->userRepository->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            return new VerificationResult(false, 'Nieprawidłowy lub wygasły token weryfikacyjny.');
        }

        if ($user->isEmailVerified()) {
            return new VerificationResult(false, 'Email został już potwierdzony.', 'info');
        }

        $user->setEmailVerified();
        $this->entityManager->flush();

        return new VerificationResult(true, 'Email został pomyślnie potwierdzony. Możesz się teraz zalogować.');
    }
}
