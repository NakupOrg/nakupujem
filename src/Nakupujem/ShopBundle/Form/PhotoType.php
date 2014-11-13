<?php

namespace Nakupujem\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Nakupujem\ShopBundle\Entity\Photo;

class PhotoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label' => false,
                ))
        ;
    }
    

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nakupujem\ShopBundle\Entity\Photo',
            'empty_data' => new Photo(),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nakupujem_shopbundle_photo';
    }
}
