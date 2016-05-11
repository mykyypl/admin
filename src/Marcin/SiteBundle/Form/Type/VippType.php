<?php

/* 
 * Marcin Kukliński
 */


namespace Marcin\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VippType extends AbstractType
{
    public function getName()
    {
        return 'marcin_sitebundle_vipp';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa', 'text', array(
            'disabled' => true,
            // 'label' => 'Nazwa',
                'label' => false,
                'attr' => array(
                    'class' => 'form-control nazwa',
                    'read_only' => true
                )
            ))
//            ->add('kod', 'text', array(
//            'disabled' => true,
//            // 'label' => 'Nazwa',
//                'label' => false,
//                'attr' => array(
//                    'class' => 'form-control',
//                    'read_only' => true
//                )
//            ))
//            ->add('wariant', 'text', array(
//            'disabled' => true,
//            // 'label' => 'Nazwa',
//                'label' => false,
//                'attr' => array(
//                    'class' => 'form-control',
//                    'read_only' => true
//                )
//            ))
            ->add('zrealizowano', 'checkbox', array(
            // 'label'     => 'zaplacono?',
                'label' => false,
              'required'  => false,
                'attr' => array (
                    'class' => 'minimal'
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