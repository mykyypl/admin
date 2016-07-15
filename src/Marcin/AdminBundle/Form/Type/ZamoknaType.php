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
                'required' => true,
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('felc', 'text', array(
                'label' => 'Felc',
                'required' => true,
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control'
                )
            ))
            ->add('oscieznica', 'choice', array(
                'label' => 'Ościeżnica:',
                'required' => true,
                'multiple' => false,
                'choices' => array(
                    '' => 'Wybież',
                    'Kańciasta' => 'Kańciasta',
                    'Zaokrąglona' => 'Zaokrąglona',
                    'Bez uszczelki' => 'Bez uszczelki',
                    'Z okapnikiem' => 'Z okapnikiem'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('skrzydlo', 'choice', array(
                'label' => 'Skrzydlo:',
                'required' => true,
                'multiple' => false,
                'choices' => array(
                    '' => 'Wybież',
                    'Cofnięte' => 'Cofnięte',
                    'Pół-lico' => 'Pół-lico',
                    'Lico' => 'Lico',
                    'Z okapnikiem' => 'Z okapnikiem'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))    
            ->add('blaszka', 'text', array(
                'label' => 'Blaszka standard',
                'required' => false,
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('blaszkaex', 'text', array(
                'label' => 'Blaszka Exclusive',
                'required' => false,
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('rodzaj', 'choice', array(
                'label' => 'Rodzaj:',
                'required' => true,
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
            //->add('stronawiercenia', 'text', array(
            //    'label' => 'Strona wiercenia',
             //   'attr' => array(
             //       'autocomplete' => 'on',
             //       'class' => 'form-control',
             //   )
           // ))
            ->add('stronawiercenia', 'choice', array(
                'label' => 'Strona wiercenia:',
                'required' => true,
                'multiple' => false,
                'choices' => array(
                    '' => 'Wybież',
                    'S' => 'S',
                    'O' => 'O'
                ),
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('stalaszer', 'text', array(
                'label' => 'Stała szerokośc',
                'required' => true,
                'attr' => array(
                    'autocomplete' => 'on',
                    'class' => 'form-control',
                )
            ))
            ->add('stalawys', 'text', array(
                'label' => 'Stała wysokość',
                'required' => true,
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