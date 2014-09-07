<?php

namespace Nakupujem\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactFormType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array(
                'attr' => array('placeholder' => 'Predmet...', 'class' => 'form-control')))
            ->add('message', 'textarea', array(
                'attr' => array('placeholder' => 'Správa...', 'class' => 'wysihtml5 form-control', 'rows' => 5)))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nakupujem_shopbundle_contact_form';
    }
}
