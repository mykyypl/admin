<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoletkinazwaType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_roletkinazwa';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roletkinazwa', 'text', array(
                'label' => 'Nazwa',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz',
                'attr' => array(
                    'class' => 'btn btn-success btn-block'
                )
            ));
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marcin\AdminBundle\Entity\Roletkinazwa'
        ));
    }
}