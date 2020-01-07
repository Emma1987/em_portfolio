<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label'          => 'Prénom',
                'attr'           => ['class' => 'form-control form-control-sm'],
                'constraints'    => [new NotBlank()],
            ])
            ->add('lastName', TextType::class, [
                'label'          => 'Nom',
                'attr'           => ['class' => 'form-control form-control-sm'],
                'constraints'    => [new NotBlank()],
            ])
            ->add('email', EmailType::class, [
                'attr'           => ['class' => 'form-control form-control-sm'],
                'constraints'    => [new NotBlank(), new Email()],
            ])
            ->add('message', TextareaType::class, [
                'attr'           => ['class' => 'form-control form-control-sm', 'rows' => 5],
                'constraints'    => [new NotBlank(), new Length(['min' => 10])],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
