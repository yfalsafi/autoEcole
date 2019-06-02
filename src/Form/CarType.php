<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', EmailType::class, array('label' => 'form.email'))
            ->add('model', null, array('label' => 'form.username'))
            ->add('immatriculation',null, array('label' => 'Nom'))
            ->add('kilometer',IntegerType::class, array('label' => 'Kilometre'))
            ->add('purchasedAt',DateType::class,['label' => 'Date de naissance'])
            ->add('isAvailable',ChoiceType::class, [
                'choices' => [
                    'Disponible' => true,
                    'Indisponible' => false
                ],'multiple'=>false
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
