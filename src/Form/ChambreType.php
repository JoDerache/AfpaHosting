<?php

namespace App\Form;

use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroClefs', ChoiceType::class, [
                'choices' =>[
                    '000001' => '000001',
                    '000002' => '000002',
                    '000003' => '000003',
                    '000004' => '000004',
                    '000005' => '000005',
                    '000006' => '000006',
                    '000007' => '000007',
                    '000008' => '000008',
                    '000009' => '000009',
                    '000010' => '000010',
                    '000011' => '000011'
                ],
                'attr' => [
                    'class' => 'form-select select_choice'
                ],
                'label' => 'Numéro de clefs'
            ])
            ->add('status', ChoiceType::class, [
                'choices' =>[
                    'Libre' => 'libre',
                    'Occupé' => 'occupé',
                    'Réservé' => 'Réservé',
                    'En travaux' => 'En travaux',
                    'Local Technique' => 'Local Technique'                    
                ],
                'attr' => [
                    'class' => 'form-select select_choice'
                ],
                'label' => 'Status de la chambre'
            ])
            // ->add('numeroEtage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
