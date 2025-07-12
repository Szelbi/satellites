<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\EmailVerificationService;
use App\Service\UserRegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home_page');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserRegistrationHandler $registrationService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registrationService->registerUser(
                $user,
                $form->get('plainPassword')->getData()
            );

            $this->addFlash('success', 'Konto zostało utworzone. Sprawdź email i potwierdź swoją rejestrację.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify-email', name: 'app_verify_email')]
    public function verifyEmail(Request $request, EmailVerificationService $verificationService): Response
    {
        $token = $request->query->get('token', '');
        $result = $verificationService->verifyEmailToken($token);

        $flashType = $result->success ? 'success' : $result->type;
        $this->addFlash($flashType, $result->message);

        return $this->redirectToRoute('app_login');
    }
}

