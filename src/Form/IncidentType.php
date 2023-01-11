<?php

namespace App\Form;

use DateTime;
use App\Entity\Bail;
use DateTimeImmutable;
use App\Entity\Incident;
use App\Entity\TypeIncident;
use App\Repository\BailRepository;
use App\Repository\IncidentRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use function PHPUnit\Framework\returnSelf;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class IncidentType extends AbstractType
{
    public function __construct(private BailRepository $bail)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options, ): void
    {
        // $date = new DateTime();
        
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

            ->add('idTypeIncident',EntityType ::class,
            [
                'class'=>TypeIncident::class,
                'label'=>'Type Incident',
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
                
            ])
            ;

            $formModifier = function (FormInterface $form, ?DateTime $data = null){
                dump($data);
                $heberge = $data === null ?[]:$this->bail->Heberge($data->format('Y-m-d'));
                $form->add('idBail', EntityType ::class, [
                    'placeholder'=> " ",
                    'label'=>"Hébergé",
                    'class'=>Bail::class,
                    'attr' => [
                        'class' => 'form-select',
                    ],
                    'choices'=> $heberge]);     
            };

            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function(FormEvent $event)use ($formModifier) {
                    $data = $event->getData()->getDate();
                    $formModifier($event->getForm(), $data);
                }
            );

            $builder->addEventListener(
                FormEvents::POST_SET_DATA,
                function(FormEvent $event)use ($formModifier) {
                    $data = $event->getData()->getDate();
                    $formModifier($event->getForm(), $data);
                    }
                );

            // $builder->get('date')->addEventListener(
            //     FormEvents::POST_SUBMIT,
            //     function(FormEvent $event)use ($formModifier) {
            //         $data = $event->getData()->getDate();
            //         $formModifier($event->getForm(), $data);
            //         }
            //     );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
