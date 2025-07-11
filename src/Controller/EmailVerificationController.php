<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailVerificationController extends AbstractController
{
    #[Route('/verify-email', name: 'app_verify_email')]
    public function verifyEmail(string $token, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$token) {
            $this->addFlash('error', 'Nieprawidłowy link weryfikacyjny.');
            return $this->redirectToRoute('app_login_index');
        }

        $user = $userRepository->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Nieprawidłowy lub wygasły token weryfikacyjny.');
            return $this->redirectToRoute('app_login_index');
        }

        if ($user->isEmailVerified()) {
            $this->addFlash('info', 'Email został już potwierdzony.');
            return $this->redirectToRoute('app_login_index');
        }

        $user->setEmailVerified(true);
        $user->setVerificationToken(null);
        $entityManager->flush();

        $this->addFlash('success', 'Email został pomyślnie potwierdzony. Możesz się teraz zalogować.');
        return $this->redirectToRoute('app_login_index');
    }
}
