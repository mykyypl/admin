<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KomunikatyzamowieniaType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_komunikatyzamowienia';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('trasa', 'text', array(
//                'label' => 'Trasa',
//                'attr' => array(
//                    'autocomplete' => 'off',
//                    'class' => 'form-control',
//                )
//            ))
            ->add('trasa', 'choice', array(
                'label' => 'Trasa',
                'multiple' => false,
                'choices' => array(
                    //'ROLE_USER' => 'Użytkownik',
                    'poniedzialek' => 'Poniedziałek',
                    'wtorek' => 'Wtorek',
                    'sroda' => 'Środa',
                    'czwartek' => 'Czwartek',
                    'piatek' => 'Piątek',
                    'tarnow' => 'Tarnów',
                    'tadeusz' => 'Tadeusz',
                    'odbior' => 'Odbiór',
                    'salon' => 'Salon',
                    'tuchowska' => 'Tuchowska',
                    'montaz' => 'Montaż',
                    'wysylka' => 'Wysyłka'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('tresc', 'textarea', array(
                'label' => 'Treść',
                'attr' => array(
                    'class' => 'tinymce'
                )
            ))
//            ->add('dzien', 'text', array(
//                'label' => 'Dzień(przed dzień trasy)',
//                'attr' => array(
//                    'autocomplete' => 'off',
//                    'class' => 'form-control',
//                )
//            ))
            ->add('dzien', 'choice', array(
                'label' => 'Dzień(przed dzień trasy)',
                'multiple' => false,
                'choices' => array(
                    //'ROLE_USER' => 'Użytkownik',
                    '1' => 'Poniedziałek',
                    '2' => 'Wtorek',
                    '3' => 'Środa',
                    '4' => 'Czwartek',
                    '5' => 'Piątek'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
//            ->add('kolor', 'text', array(
//                'label' => 'Kolor komunikatu',
//                'attr' => array(
//                    'autocomplete' => 'on',
//                    'class' => 'form-control',
//                )
//            ))
            ->add('kolor', 'choice', array(
                'label' => 'Kolor komunikatu:',
                'multiple' => false,
                'choices' => array(
                    //'ROLE_USER' => 'Użytkownik',
                    'danger' => 'Czerwony',
                    'info' => 'Niebieski',
                    'warning' => 'Żółty',
                    'success' => 'Zielony'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('wlaczone', 'checkbox', array(
            'label'     => 'Włączony?',
                //'label' => false,
              'required'  => false,
                'attr' => array (
                    'class' => 'minimal'
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
            'data_class' => 'Marcin\AdminBundle\Entity\Komunikatyzamowienia'
        ));
    }
}