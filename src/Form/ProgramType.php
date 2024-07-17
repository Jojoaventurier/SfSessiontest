<?php

namespace App\Form;

use App\Entity\Unit;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('session', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => 'sessionName', //choix du champs récupéré pour la création du formulaire (le nom doit être celui qui correspond dans l'entité pas dans la BDD)
            //     'label' => 'Nom de la session' // label affiché
            // ])
            // ->add('unit', EntityType::class, [
            //     'class' => Unit::class,
            //     'choice_label' => 'unitName',
            //     'label' => 'Module'
            // ])
            // ->add('numberOfDays', IntegerType::class, [
            //     'label' => 'Durée du module (en jours)'
            // ])
            ->add('programs', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('valider', SubmitType::class) // (ne pas oublier d'importer les classes que l'on rajoute manuellement au formulaire)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class, 
        ]);
    }
}
