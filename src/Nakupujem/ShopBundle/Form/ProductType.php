<?php

namespace Nakupujem\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('top', 'choice', array(
                'choices' => array('y' => 'Áno', 'n' => 'Nie'),
                'required' => 'true',
                ))
            ->add('subcategory', 'entity', array(
                'class' => 'NakupujemShopBundle:Subcategory',
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'property' => 'name',
                ))
            ->add('photo', 'collection', array(
                'type' => new PhotoType(),
                'label' => true,
                'required' => false,
                ))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nakupujem\ShopBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nakupujem_shopbundle_product';
    }
}
