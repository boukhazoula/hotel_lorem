<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Nom"]
        ])
        ->add('prenom', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Prénom"]
        ])
        ->add('tel', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Numéro de téléphone"]
        ])
        ->add('adresse', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Adresse"]
        ])
        ->add('ville', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Ville"]
        ])
        ->add('cp', null, [
            'label'=>false,
            'attr' =>[
            
            'placeholder'=>"Code postal"
            ]
        ])
        ->add('pays', null, [
            'label'=>false,
            'attr' =>[
            'placeholder'=>"Pays"
            ]
        ])
        ;

    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
