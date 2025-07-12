<?php
declare(strict_types=1);

namespace App\Communication\UserInterface\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'contact_form.your_email',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'contact_form.your_message',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10]),
                ],
            ]);
    }
}
