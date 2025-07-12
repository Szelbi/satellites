<?php

namespace App\Shared\UserInterface\Web\Trait;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait FormHandleTrait
{
    public array $formErrors = [];

    public int $responseStatus = Response::HTTP_OK;

    public function handleForm(FormInterface $form, Request $request, bool $isPatchMethod = false): bool
    {
        $form->submit(json_decode($request->getContent(), true), !$isPatchMethod);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->responseStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
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
