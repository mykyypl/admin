<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsletterType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_newsletter';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tytul', 'text', array(
                'label' => 'Tytuł',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('tekst', 'textarea', array(
                'label' => 'Treść',
                'attr' => array(
                    'class' => 'tinymce'
                )
            ))
            ->add('bootstrap', 'checkbox', array(
             'label'     => 'Załączyć bibliotekę Bootstrap?',
              'required'  => false,
                'attr' => array (
                    'class' => 'minimal'
                )
            ))
            ->add('test', 'text', array(
                'label' => 'Wpisz testowy email',
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('grupy', 'choice', array(
                'label' => 'Grupy użytkoników:',
                'multiple' => true,
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
                    'class' => 'select2 form-control'
                )
            ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz',
                'attr' => array(
                    'class' => 'btn btn-success btn-block'
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Wyślij newsletter!',
                'attr' => array(
                    'class' => 'btn btn-danger btn-block',
                    'onclick' => "waitingDialog.show('Trwa wysyłanie... proszę poczekać na odświeżenie strony!');setTimeout(function () {waitingDialog.hide();}, 200000);"
                )
            ))
            ->add('send', 'submit', array(
                'label' => 'Wyślij testowy email',
                'attr' => array(
                    'class' => 'btn btn-info btn-block'
                )
            ));
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marcin\AdminBundle\Entity\Newsletter'
        ));
    }
}