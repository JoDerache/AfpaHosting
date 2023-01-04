<?php

namespace App\Form;

use App\Entity\Bail;
use DateTimeImmutable;
use App\Entity\Incident;
use App\Entity\TypeIncident;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use function PHPUnit\Framework\returnSelf;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options, ): void
    {
        
        $builder 
            ->add('date', DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'],
            ])
            ->add('commentaire', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'],
            ] )
            ->add('idBail', EntityType ::class, [
                'placeholder'=> " ",
                'label'=>"Hébergé",
                'class'=>Bail::class,
                'attr' => [
                'class' => 'form-select',
                ],
                'query_builder'=>function (EntityRepository $er){
                    return $er->createQueryBuilder('b')
                        // ->where('b.dateEntree<date')
                        ->orderBy('b.idPersonne','ASC');
                }
            ])

            // ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            //     $form = $event->getForm();
            //     $data = $event->getData();
            //     $date = $data->getDate();

            //     if ($date !== null){
            //         $event->getForm()->add('idBail', EntityType ::class, [
            //                 'placeholder'=> " ",
            //                 'label'=>"Hébergé",
            //                 'class'=>Bail::class,
            //                 'attr' => [
            //                     'class' => 'form-select',],]
            //                 );
            //     }
            // }
            // )


            ->add('idTypeIncident',EntityType ::class,
            [
                'class'=>TypeIncident::class,
                'placeholder'=> " ",
                'attr' => [
                    'class' => 'form-select'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
                'label' => 'Enregistrer',
                'validation_groups' => false,
                'label_html' => true,
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
