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
            
            ->add('unit', EntityType::class, [
                'class' => Unit::class,
                'choice_label' => 'unitName',
                'label' => 'Module',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('a')
                    ->orderBy('a.unitName','ASC');}
            ])
            ->add('numberOfDays', IntegerType::class, [
                'label' => 'Durée du module (en jours)'
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
