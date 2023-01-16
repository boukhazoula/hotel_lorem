<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Category;
use App\Services\RechercheChambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RechercheChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_arrive', DateType::class,[
                'widget' => 'single_text'
                
            ])
            ->add('date_depart', DateType::class,[
                'widget'=> 'single_text',
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[date_arrive].data',
                        'message' => 'Erreur sur la date'
                    ])]
            ])

            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RechercheChambre::class,
        ]);
    }
}
