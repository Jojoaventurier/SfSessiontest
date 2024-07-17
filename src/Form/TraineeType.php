<?php

namespace App\Form;

use App\Entity\Trainee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [ // filtres utilisant les classes natives de symfony
                'label' => 'Prénom' // label affiché sur la page pour l'utilisateur
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille'
            ])
            ->add('gender', TextType::class, [
                'label' => 'Sexe'
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email'
            ]) 
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone'
            ]) 
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ]) 
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}
