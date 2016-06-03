<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UzytkownicyType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_uzytkownicytype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imienazw', 'text', array(
                'label' => 'Imię i nazwisko',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('login', 'text', array(
                'disabled' => true,
                'label' => 'Login użytkownika',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                     'read_only' => true
                )
            ))
            ->add('email', 'text', array(
                'label' => 'Email użytkownika',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('adminstatus', 'choice', array(
                'label' => 'Administrator:',
                'multiple' => false,
                'choices' => array(
                    //'ROLE_USER' => 'Użytkownik',
                    'admin' => 'TAK',
                    '' => 'NIE'
                ),
                'attr' => array(
                    'class' => 'form-control'
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
            'data_class' => 'Marcin\AdminBundle\Entity\Username'
        ));
    }
}