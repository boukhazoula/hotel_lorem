<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tarif',null,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>"Tarif"
                ]
            ])
            ->add('titre',null,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>"Titre"
                ]
            ])
            ->add('numero',null,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>"Numéro"
                ]
            ])
            ->add('description',null,[
                'label'=>false,
                'attr'=>[
                    'placeholder'=>"Description"
                ]
            ])
            ->add('image', FileType::class,[
                'data_class' => null,
                'required' => false,
                'empty_data' => ""
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
            'data_class' => Chambre::class,
        ]);
    }
}
