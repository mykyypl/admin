<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TestType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_testype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'text', array(
                'label' => 'User',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('status', 'choice', array(
                'choices'   => array('przesłane do realizacji' => 'przesłane do realizacji', 'przyjęte do realizacji' => 'przyjęte do realizacji', 'w realizacji' => 'w realizacji', 'zrealizowane' => 'zrealizowane', 'odebrane' => 'odebrane'),
                'required'  => false,
                'empty_value'       => 'Proszę wybrać status',
                'attr' => array (
                    'class' => 'form-control'
                )
            ))
            ->add('do_zaplaty', 'number', array(
                'label' => 'Kwota',
                'attr' => array (
                    'class' => 'form-control'
                )
            ))
            ->add('zaplacono', 'checkbox', array(
             'label'     => 'zaplacono?',
              'required'  => false,
                'attr' => array (
                    'class' => 'minimal'
                )
 ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ));
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marcin\AdminBundle\Entity\Zamowienia'
        ));
    }
}