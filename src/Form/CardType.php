<?php

namespace App\Form;

use App\Entity\CardName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('card_name', TextareaType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Indiquez le nom de la carte'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Le nom de la carte doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de la carte ne doit pas contenir plus de {{ limit }} caractères.'
                        ])
                    ],
                    ])
            ->add('number_cards_in_collection', TextType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Veuillez saisir le nombre d\'exemplaire de la carte'
                    ])
                ],
            ])


            ->add('card_value_euros', TextType::class,[
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Veuillez saisir le prix de la carte'
                    ])
                ],
            ])

            ->add('card_image', FileType::class,[
                'data_class' => null,
                'required' =>false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024K'
                    ])
                ]
            ])

            ->add('purchase_date')
            
            ->add('release_date')

            ->add('is_on_sale', CheckboxType::class, [
                'required' => false
            ])

            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer la description de la carte'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => "Votre description doit au moins contenir {{ limit }} caractères."
                    ])
                ]
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CardName::class,
        ]);
    }
}
