<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduktyType extends AbstractType
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
                    'class' => 'form-control',
                )
            ))
            ->add('id_zam', 'text', array(
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
            'data_class' => 'Marcin\AdminBundle\Entity\Produkty'
        ));
    }
}