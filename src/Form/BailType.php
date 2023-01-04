<?php

namespace App\Form;

use App\Entity\Bail;
use App\Entity\Chambre;
use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('dateEntree', DateType::class, [
                'label' => 'Date d\'entrée',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateSortie', DateType::class, [
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('idPersonne', EntityType::class, [
            // 'expanded' => true,
            'class' => Personne::class,
            'choice_value' =>  function (?Personne $entity) {
                return $entity ? $entity->getNom()." ". $entity->getPrenom() : '';
            },
            'multiple' => false,
            'label' => 'Attribuer à l\'hébergé',
            'attr' => ['class' => 'form-select']
            ])
            // ->add('numeroChambre', EntityType::class, [
            //     // 'expanded' => true,
            //     'class' => Chambre::class,
            //     'multiple' => false,
            //     'label' => 'Attribuer la chambre',
            //     'attr' => ['class' => 'form-select']
            //     ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bail::class,
        ]);
    }
}
