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

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'sessionName', //choix du champs récupéré pour la créaiton du formulaire (le nom doit être celui qui correspond dans l'entité pas dans la BDD)
                'label' => 'Nom de la session'
            ])
            ->add('unit', EntityType::class, [
                'class' => Unit::class,
                'choice_label' => 'unitName',
            ])
            ->add('numberOfDays', IntegerType::class)
            ->add('valider', SubmitType::class) // ne pas oublier d'importer les classes que l'on rajoute
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class, 
        ]);
    }
}
