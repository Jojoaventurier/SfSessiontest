<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


use Symfony\Component\Validator\Constraints as Assert; //on utilise Assert pour les contraintes que l'on souhaite imposer sur la création de mot de passe

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class) // on spécifie le type de données attendu en utilisant les classes natives de Symphony
            ->add('userName', TextType::class) // idem
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci d\'accepter les termes pour valider l\'inscription',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [ //on utilise RepeatedType::class pour avoir la répétition des mots de passes à l'enregistrement
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne correspondent pas.',
                'options' => [
                    'attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
                'constraints' => [
                    new Assert\NotBlank([ // le mot de passe ne doit pas être vide
                        'message' => 'Veuillez entrer un mot de passe'
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', // pattern imposé pour la création du mot de passe
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et avoir au moins 8 caractères.',
                        ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
