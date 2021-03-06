<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvestpType extends AbstractType
{
    public function getName()
    {
        return 'marcin_adminbundle_investp';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa', 'text', array(
                'label' => false,//'Nazwa produktu',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('wariant', 'text', array(
                'label' => false,//'Warianty produktu',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'required' => false,
                )
            ))
            ->add('kod', 'text', array(
                'label' => false,//'Warianty produktu',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'required' => false,
                )
            ))
            ->add('ilosc', 'text', array(
                'label' => false,//'Ilości produktu',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('jednostka', 'text', array(
                'label' => false,//'Warianty produktu',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('uwagi', 'textarea', array(
                'label' => false,//'Profil produktu',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'required' => false,
                   // 'required'    => true,
                )
            ))
            ->add('files', 'file', array(
               // 'label' => 'Faktura',
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'upload',
                    'required' => false,
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