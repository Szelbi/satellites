<?php

namespace App\Communication\UserInterface\Web\Controller;

use App\Communication\Application\Service\SendContactMessageHandler;
use App\Communication\UserInterface\Web\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form_index')]
    public function contact(Request $request, SendContactMessageHandler $contactService): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $contactService->processContactForm($data['email'], $data['message']);

            $this->addFlash('success', 'Your message has been sent!'); //todo translations
            return $this->redirectToRoute('home_page');
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
