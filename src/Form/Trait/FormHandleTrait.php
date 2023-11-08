<?php

namespace App\Form\Trait;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait FormHandleTrait
{
    public function handleForm(FormInterface $form, Request $request): bool
    {
        $form->submit(json_decode($request->getContent(), true), false);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        return true;
    }

    private function getErrorsFromForm($form): array
    {
        $errors = array();

        foreach ($form as $child) {
            foreach ($child->getErrors() as $error) {
                $errors[$child->getName()] = $error->getMessage();
            }
        }

        return $errors;
    }
}
