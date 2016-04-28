<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class KlinarType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_klin';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie', 'text', array(
                'label' => 'Imię',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nazwisko', 'text', array(
                'label' => 'Nazwisko',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('firma', 'text', array(
                'label' => 'Firma',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('adres1', 'text', array(
                'label' => 'Adres',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('adres2', 'text', array(
                'label' => 'Adres',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('miejscowosc', 'text', array(
                'label' => 'Miejscowosc',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('kodpocztowy', 'text', array(
                'label' => 'Kod pocztowy',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('datamaxdo', 'datetime', array(
                'label' => 'Data realizacji',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('uwagi', 'textarea', array(
                'label' => 'Uwagi do zamówienia',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('klinaryt', 'checkbox', array(
            'label'     => 'Klinaryt?',
                //'label' => false,
              'required'  => false,
                'attr' => array (
                    'class' => 'minimal'
                )
            ))
            ->add('shoper1', CollectionType::class, array(
                'entry_type' => KlinarpType::class
                    ))
            ->add('save', 'submit', array(
                'label' => 'Zapisz i przejdź do podsumowania',
                'attr' => array(
                    'class' => 'btn btn-success fixedposition'
                )
            ));
    }
    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Marcin\SiteBundle\Entity\Shoperklinar'
        ));
    }
}