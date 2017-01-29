<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Imię:',
            'attr' => array(
                'placeholder' => 'Wpisz imię',
            ),
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AdminBundle\Entity\User']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_bundle_new_user_form';
    }
}
