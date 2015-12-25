<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('plainPassword', RepeatedType::class, array (
                'type' => PasswordType::class)
            );
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
    
}