<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class VipType extends AbstractType
{
    public function getName()
    {
        return 'vip';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('nrlistu', 'text', array(
//                'label' => 'Nr listu przewozowego (uzupełnienie ustawia na zrealizowane)',
//                'attr' => array(
//                    'class' => 'form-control',
//                )
//            ))
//            ->add('nrlistu', CollectionType::class, array(
//    // each entry in the array will be an "email" field
//    'entry_type'   => TextType::class,
//    'allow_add' => true,
//    'allow_delete' => true,
//   // 'label' => 'Nr listu przewozowego',
//    //'prototype' => true,
//    //'prototype_data' => 'New Tag Placeholder',
//    // these options are passed to each "email" type
//    'entry_options'  => array(
//                'attr'      => array('class' => 'form-control')
//            ),
//            ))
            ->add('nrlistu', CheckboxType::class, array(
                'label'    => 'Zamówienie zostało wysłane: ',
                'required' => false,
                'attr' => array(
                    'class' => 'minimal',
                )
            ))
            ->add('file', 'file', array(
               // 'label' => 'Faktura',
                'label' => false,
                'attr' => array(
                    'class' => 'upload',
                )
            ))
            ->add('uwagiklinar', 'textarea', array(
                'label' => 'Uwagi od producenta',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('shoper1', CollectionType::class, array(
                'entry_type' => VippType::class
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