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
            ->add('name', 'text')
            ->add('lastname', 'text')
            ->add('username', 'text')
            ->add('password', 'repeated', array(
            	'type' => 'password',
            	'invalid_message' => 'Heslá sa musia zhodovať!',
            	'required' => true,
			    'first_options'  => array('label' => 'Heslo:'),
			    'second_options' => array('label' => 'Heslo znova:'),
            	))
            ->add('email', 'email')
            ->add('location', 'text')
            ->add('shipping')
            ->add('phone')
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
