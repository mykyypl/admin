<?php
namespace Common\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class ManageUserChangePasswordType extends AbstractType {
    
    public function getName() {
        return 'changePassword';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array(
                    'label' => 'Nowe hasło',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
                'second_options' => array(
                    'label' => 'Powtórz hasło',
                'attr' => array(
                    'class' => 'form-control'
                )
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Zmień hasło',
                'attr' => array(
                        'class' => 'btn-default btn'
                    )
            ));
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Common\UserBundle\Entity\User',
            'validation_groups' => array('Default', 'ChangePassword')
        ));
    }
}