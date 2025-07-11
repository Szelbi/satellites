<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login_index', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main_page');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/verify-email', name: 'app_verify_email')]
    public function verifyEmail(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $token = $request->query->get('token');

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

        $user->setEmailVerified();

        $entityManager->flush();

        $this->addFlash('success', 'Email został pomyślnie potwierdzony. Możesz się teraz zalogować.');
        return $this->redirectToRoute('app_login_index');
    }
}
