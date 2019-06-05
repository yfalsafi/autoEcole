<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 04/06/2019
 * Time: 17:57
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatchUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('name',null, array('label' => 'Nom','attr' => ['pattern' => '[a-zA-Z]*']))
            ->add('firstName',null, array('label' => 'Prenom','attr' => ['pattern' => '[a-zA-Z]*']))
            ->add('address',null, array('label' => 'Adresse'))
            ->add('city',null, array('label' => 'Ville'))
            ->add('status',ChoiceType::class, [
                'choices' => [
                    'Code' => "code",
                    'Conduite' => "driving"
                ],'multiple'=>false
            ])
            ->add('enabled',ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],'multiple'=>false
            ])
            ->add('isInstructor',ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],'multiple'=>false
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'data_class' => User::class,
            'allow_extra_fields'=> true,
        ]);
    }
}