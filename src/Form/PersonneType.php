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
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('badge', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numéro de Badge'
                
            ])
            ->add('lieuNaissance', TextType::class, [
                'attr' => [
                    'class' => 'form-select'],
                    'label' => 'Lieu de Naissance'
            ])
            // ->add('idLogin')
            // ->add('numeroBeneficiaire')
            // ->add('isBlacklisted')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
