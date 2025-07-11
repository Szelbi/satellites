<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
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

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $verificationToken = bin2hex(random_bytes(32));
            $user->setVerificationToken($verificationToken);
            $user->setEmailVerified(false);

            $entityManager->persist($user);
            $entityManager->flush();

            $mailerService->sendEmailVerification($user->getEmail(), $verificationToken);

            $this->addFlash('success', 'Konto zostało utworzone. Sprawdź email i potwierdź swoją rejestrację.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify-email', name: 'app_verify_email')]
    public function verifyEmail(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $token = $request->query->get('token');

        if (!$token) {
            $this->addFlash('error', 'Nieprawidłowy link weryfikacyjny.');
            return $this->redirectToRoute('app_login');
        }

        $user = $userRepository->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Nieprawidłowy lub wygasły token weryfikacyjny.');
            return $this->redirectToRoute('app_login');
        }

        if ($user->isEmailVerified()) {
            $this->addFlash('info', 'Email został już potwierdzony.');
            return $this->redirectToRoute('app_login');
        }

        $user->setEmailVerified();

        $entityManager->flush();

        $this->addFlash('success', 'Email został pomyślnie potwierdzony. Możesz się teraz zalogować.');
        return $this->redirectToRoute('app_login');
    }
}
