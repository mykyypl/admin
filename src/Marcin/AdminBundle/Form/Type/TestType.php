<?php

/* 
 * Marcin Kukliński
 */


namespace Tom\AdminBundle\Form\Type;

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
            ->add('jakie_zam', 'text', array(
                'label' => 'jakie zam',
                'attr' => array(
                    'class' => 'tinymce'
                )
            ))
            ->add('$status', 'file', array(
                'label' => 'Zdjęcie'
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
            'data_class' => 'Tom\SiteBundle\Entity\Slider'
        ));
    }
}