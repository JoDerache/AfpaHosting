<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdatePersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom')
            // ->add('prenom')
            ->add('adressePostale', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                ],
            ])

            ->add('telephone', TelType::class, [
                'attr' => [
                    'class'=>'form-control',
                ],
            ])

            ->add('mail', EmailType::class, [
                'attr' => [
                    'class'=>'form-control',
                ],
            ])
            // ->add('dateNaissance')
            // ->add('badge')
            // ->add('numeroBeneficiaire')
            // ->add('isBlacklisted')
            // ->add('lieuNaissance')
            // ->add('idLogin')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'id' => 'bouton',
                    'class'=>'btn btn-danger card-btn',
                ],
                'label' => 'Enregistrer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
