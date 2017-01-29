<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewCategoryForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', TextType::class, [
            'label' => 'Kategoria:',
            'attr' => array(
                'placeholder' => 'Wpisz nazwę kategorii',
            ),
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AdminBundle\Entity\Category']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_bundle_new_category_form';
    }
}
