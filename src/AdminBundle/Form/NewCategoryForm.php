<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewCategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('category', TextType::class, [
            'label' => 'Kategoria:',
            'attr' => array(
                'placeholder' => 'Wpisz nazwę kategorii',
            ),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AdminBundle\Entity\Category']);
    }

    public function getName()
    {
        return 'admin_bundle_new_category_form';
    }
}
