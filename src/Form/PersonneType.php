<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('adressePostale')
            ->add('telephone')
            ->add('mail')
            ->add('dateNaissance')
            ->add('badge')
            ->add('numeroBeneficiaire')
            ->add('isBlacklisted')
            ->add('lieuNaissance')
            ->add('idLogin')
            // ->add('save')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
