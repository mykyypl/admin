<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZamoknaType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_zamokna';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nazwa',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('felc', 'text', array(
                'label' => 'Felc',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control'
                )
            ))
            ->add('oscieznica', 'text', array(
                'label' => 'Ościeżnica',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('skrzydlo', 'text', array(
                'label' => 'Skrzydlo',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('blaszka', 'text', array(
                'label' => 'Blaszka',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('rodzaj', 'choice', array(
                'label' => 'Rodzaj:',
                'multiple' => false,
                'choices' => array(
                    '' => 'Wybież',
                    'PCV' => 'PCV',
                    'ALU' => 'ALU',
                    'DRE' => 'DRE'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('stronawiercenia', 'text', array(
                'label' => 'Strona wiercenia',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('stalaszer', 'text', array(
                'label' => 'Stała szerokośc',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('stalawys', 'text', array(
                'label' => 'Stała wysokość',
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
            'data_class' => 'Marcin\AdminBundle\Entity\Zamokna'
        ));
    }
}