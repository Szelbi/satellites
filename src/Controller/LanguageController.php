<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LanguageController extends AbstractController
{
    #[Route('/change-language/{locale}', name: 'change_language', requirements: ['locale' => 'en|pl|fr'])]
    public function changeLanguage(string $locale, Request $request, SessionInterface $session): RedirectResponse
    {
        $session->set('_locale', $locale);

        return new RedirectResponse($request->headers->get('referer', '/'));
    }
}
