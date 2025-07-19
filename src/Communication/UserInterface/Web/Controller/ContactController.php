<?php

namespace App\Communication\UserInterface\Web\Controller;

use App\Communication\Application\Service\SendContactMessageHandler;
use App\Communication\UserInterface\Web\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form_index')]
    public function contact(Request $request, SendContactMessageHandler $contactService, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $contactService->processContactForm($data['email'], $data['message']);

            $this->addFlash('success', $translator->trans('contact_form.message_sent'));
            return $this->redirectToRoute('home_page');
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
