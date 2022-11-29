<?php

namespace App\Form;

use App\Entity\Login;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mdp', PasswordType::class, [
                'label'=>'Ancien mot de passe',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder' => ''
                        ]
            ])

            ->add('new_password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'mapped'=>false, 
                'invalid_message'=>'lles deux mots de passe doivent être indentique',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Nouveau mot de passe',
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder' => ''
                    ]
                ],
                'second_options'=>[
                    'label'=>"Confirmer nouveau mot de passe",
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder' => ''
                ]
            ]
        ])

        ->add('submit', SubmitType::class, [
            'attr' => [
                'id' => 'bouton',
                'class'=>'btn btn-danger card-btn',
            ],
            'label' => 'Enregistrer']);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Login::class,
        ]);
    }
}
