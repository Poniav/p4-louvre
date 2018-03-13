<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                            'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                            'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                            'attr' => ['aria-describedby' => 'basic-addon1']
            ])
            ->add('date', DateType::class, [
                            'label' => 'Date de réservation',
                            'widget' => 'single_text',
                            'html5' => 'false',
                            'format' => 'dd/MM/yyyy',
                            'attr' => ['class' => 'datepicker']
            ])
            ->add('type', ChoiceType::class,[
                            'label' => 'Quel type de billet ?',
                            'choices' => [
                                'Journée' => 1,
                                'Demi-Journée' => 0
                            ]
            ])
            ->add('number', ChoiceType::class,[
                            'label' => 'Choix du nombre de billets',
                            'placeholder' => 'Choisir...',
                            'choices' => [
                                '1' => 1,
                                '2' => 2,
                                '3' => 3,
                                '4' => 4,
                                '5' => 5
                            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Booking::class,
            'validation_groups' => ['Booking']
        ));
    }
}
