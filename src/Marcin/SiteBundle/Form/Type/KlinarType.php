<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class KlinarType extends AbstractType
{
    public function getName()
    {
        return 'klinar';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nrlistu', 'text', array(
                'label' => 'Nr listu przewozowego',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('file', 'file', array(
                'label' => 'Faktura'
            ))
            ->add('uwagiklinar', 'textarea', array(
                'label' => 'Uwagi do zamówienia',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('shoper1', CollectionType::class, array(
                'entry_type' => KlinarpType::class
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
            'data_class' => 'Marcin\SiteBundle\Entity\Shoperklinar'
        ));
    }
}