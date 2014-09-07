<?php

namespace Nakupujem\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterUserType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Meno...'),
                ))
            ->add('lastname', 'text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Priezvisko...'),
                ))
            ->add('username', 'text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Prihlasovacie meno...'),
                ))
            ->add('password', 'repeated', array(
            	'type' => 'password',
            	'invalid_message' => 'Heslá sa musia zhodovať!',
            	'required' => true,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Heslo'),
			    'first_options'  => array('label' => 'Heslo', 'attr' => array('class' => 'form-control', 'placeholder' => 'Heslo...')),
			    'second_options' => array('label' => 'Heslo znova','attr' => array('class' => 'form-control', 'placeholder' => 'Heslo znova...')),
            	))
            ->add('email', 'email', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'E-mail...'),
                ))
            ->add('location', 'text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Okolie...'),
                ))
            ->add('shipping','text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Posielam do...'),
                ))
            ->add('phone','text', array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Telefónne číslo...'),
                ))
            ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'nakupujem_shopbundle_register_user';
    }
}
