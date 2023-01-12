<?php

namespace App\Form;

use App\Entity\Travaux;
use App\Entity\TypeTravaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TravauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('commentaireTravaux', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ajoutez les détails des travaux en cours...',
                    'class' => 'mt-4 mx-4',
                    'cols' => '45',
                    'rows' => '5'
                ],
                
            ])
            ->add('idTravauxTypeTravaux', EntityType::class, [
                'class' => TypeTravaux::class,
                'multiple' => false,
                'label' => 'Type de travaux',
                'attr' => [
                    'class' => 'form-select'
                ],
            ])
            // ->add('numeroChambre')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary submitChambre',
                    
                ],
                'label' => 'Enregistrer',
                'validation_groups' => false,
                'label_html' => true,
                
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travaux::class,
        ]);
    }
}
