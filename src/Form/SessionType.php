<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Form\ProgramType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('totalNumber', IntegerType::class, [ // filtres utilisant les classes natives de symfony
                'label' => 'Nombre total de places' // label affiché sur la page pour l'utilisateur
            ])
            ->add('sessionName', TextType::class, [ 
                'label' => 'Nom de la session'
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de démarrage'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin'
            ])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'trainingName',
                'label' => 'Choix du stage'
            ])
            ->add('programs', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
