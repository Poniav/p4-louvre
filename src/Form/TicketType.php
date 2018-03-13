<?php

namespace App\Form;

use App\Entity\Tickets;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType implements FormTypeInterface
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
            ->add('birth', DateType::class, [
                'label' => 'Quelle est votre date de naissance ?',
                'widget' => 'single_text',
                'html5' => 'false',
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'datepicker-tickets']
            ])
            ->add('discount', CheckboxType::class,[
                'label' => 'Avez-vous une réduction ?'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tickets::class,
        ));
    }
}
