<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShoperType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_shopertype';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie', 'text', array(
                'label' => 'Imię',
                'data' => 'Tadeusz',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('nazwisko', 'text', array(
                'label' => 'Nazwisko',
                'data' => 'Romański',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('firma', 'text', array(
                'label' => 'Firma',
                'data' => 'Magnum Tadeusz Romański',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('telefon', 'text', array(
                'label' => 'Telefon',
                'data' => '600 280 602',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('nip', 'text', array(
                'label' => 'NIP',
                'data' => '8731017278',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('adres1', 'text', array(
                'label' => 'Adres',
                'data' => 'Tuchowska 62',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('adres2', 'text', array(
                'label' => 'Adres',
                'data' => ' ',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('miejscowosc', 'text', array(
                'label' => 'Miejscowosc',
                'data' => 'Tarnów',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('kodpocztowy', 'text', array(
                'label' => 'Kod pocztowy',
                'data' => '33-100',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
           ->add('nazwa', 'text', array(
                'label' => 'Nazwa przedmiotu',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('wariant', 'text', array(
                'label' => 'Wariant przedmiotu',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('ilosc', 'text', array(
                'label' => 'Ilosc przedmiotu',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('jednostka', 'text', array(
                'label' => 'jednostka przedmiotu',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                )
            ))
            ->add('kod', 'text', array(
                'label' => 'Kod produktu',
                'attr' => array(
                    'autocomplete' => 'off',
                    'class' => 'form-control',
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
            'data_class' => 'Marcin\SiteBundle\Entity\Shoperzamowienia'
        ));
    }
}