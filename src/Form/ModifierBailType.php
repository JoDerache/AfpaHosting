<?php

namespace App\Form;

use App\Form\BailType;
use App\Form\ChambreType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModifierBailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bail', BailType::class,[
                'label' => false
            ])
            ->add('chambre', ChambreType::class,[
                'label' =>false
            ])
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
            // Configure your form options here
        ]);
    }
}
