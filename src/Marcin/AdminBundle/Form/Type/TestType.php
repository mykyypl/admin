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
        return 'test';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'text', array(
                'label' => 'User',
                'attr' => array(
                    'autocomplete' => 'off',
                )
            ))
            ->add('status', 'choice', array(
                'choices'   => array('przesłane do realizacji' => 'przesłane do realizacji', 'przyjęte do realizacji' => 'przyjęte do realizacji', 'w realizacji' => 'w realizacji', 'zrealizowane' => 'zrealizowane', 'odebrane' => 'odebrane'),
                'required'  => false,
                'empty_value'       => 'Proszę wybrać status',
            ))
            ->add('do_zaplaty', 'text', array(
                'label' => 'Kwota'
            ))
            ->add('zaplacono', 'checkbox', array(
             'label'     => 'zaplacono?',
              'required'  => false
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