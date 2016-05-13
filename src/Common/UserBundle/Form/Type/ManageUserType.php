<?php
namespace Common\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ManageUserType extends AbstractType
{  
    
    public function getName()
    {
        return 'manageUser';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Nazwa użytkownika',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Nazwa użytkownika'
                )
            ))
            ->add('email', 'email', array(
                'label' => 'E-mail',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'E-mail'
                )
            ));
        
        if ($options['register']) {
            $builder->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array(
                    'label' => 'Hasło',
                    'attr' => array(
                        'placeholder' => 'Hasło',
                        'class' => 'form-control',
                        'autocomplete' => 'off'
                    )
                ),
                'second_options' => array(
                    'label' => 'Powtórz hasło',
                    'attr' => array(
                        'placeholder' => 'Powtórz hasło',
                        'class' => 'form-control',
                        'autocomplete' => 'off'
                    )
                )
            ));
        }
            $builder->add('accountNonExpired', 'checkbox', array(
                'label' => 'Konto nie wygasło',
                'attr' => array(
                    'class' => 'minimal'
                )
            ))
            ->add('accountNonLocked', 'checkbox', array(
                'label' => 'Konto nie zablokowane',
                'attr' => array(
                    'class' => 'minimal'
                )
            ))
            ->add('credentialsNonExpired', 'checkbox', array(
                'label' => 'Dane uwierzytelniające nie wygasły',
                'attr' => array(
                    'class' => 'minimal'
                )
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Konto aktywowane',
                'attr' => array(
                    'class' => 'minimal'
                )
            ))
            ->add('roles', 'choice', array(
                'label' => 'Uprawnienia',
                'multiple' => true,
                'choices' => array(
                    //'ROLE_USER' => 'Użytkownik',
                    'ROLE_PROD' => 'Produkcja',
                    'ROLE_ZAM' => 'Zamówienia',
                    'ROLE_MAGNUM' => 'Admin produkcja',
                    'ROLE_ADMIN' => 'Administrator',
                    'ROLE_SUPER_ADMIN' => 'Super Administrator'
                ),
                'attr' => array(
                    'class' => 'select2 form-control'
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
            'data_class' => 'Common\UserBundle\Entity\User',
            'register' => TRUE
        ));
    }
    
}