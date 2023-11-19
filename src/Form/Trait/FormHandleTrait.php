<?php

namespace App\Form\Trait;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait FormHandleTrait
{
    public array $formErrors = [];

    public function handleForm(FormInterface $form, Request $request): bool
    {
        $form->submit(json_decode($request->getContent(), true), false);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->collectErrorsFromForm($form);
            return false;
        }

        return true;
    }

    public function collectErrorsFromForm(FormInterface $form): void
    {
        foreach ($form->getErrors(true) as $error) {
            $origin = $error->getOrigin();
            $this->formErrors[$origin->getName()][] = $error->getMessage();
        }
    }
}
