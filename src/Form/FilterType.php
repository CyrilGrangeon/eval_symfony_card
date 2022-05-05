<?php

namespace App\Form;

use App\Entity\CardName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('priceOrder', ChoiceType::class, [
            'choices' => [
                'Prix croissant' => true,
                'Prix décroissant' => false
            ],
            'mapped' => false,
            'attr' => ['class' => 'form-control'],
            'required' => false
        ])
        ->add('Filtrer', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary m-3']
        ])
        ;
    
    
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
