<?php

namespace App\Form;

use App\Entity\CardName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('card_name')
            ->add('number_cards_in_collection')
            ->add('card_value_euros')
            ->add('card_image')
            ->add('purchase_date')
            ->add('release_date')
            ->add('is_on_sale')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CardName::class,
        ]);
    }
}
