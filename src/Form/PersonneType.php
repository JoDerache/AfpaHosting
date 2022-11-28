<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'],
                    'label' => 'Nom'
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'],
                    'label' => 'Prénom'
            ])
            ->add('adressePostale', TextType::class, [
                'attr' => [
                    'class' => 'form-control'],
                    'label' => 'Adresse Postale'
            ])
            ->add('telephone', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de Téléphone'
            ])
            ->add('mail', EmailType::class,[
                'attr' => [
                    'class'  => 'form-control'
                ],
                'label' => 'Adresse Email'
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'label' => 'Date de Naissance'
            ])
            ->add('badge', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numéro de Badge'
                
            ])
            // ->add('numeroBeneficiaire')
            // ->add('isBlacklisted')
            ->add('lieuNaissance', TextType::class, [
                'attr' => [
                    'class' => 'form-control'],
                    'label' => 'Lieu de Naissance'
            ])
            // ->add('idLogin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
