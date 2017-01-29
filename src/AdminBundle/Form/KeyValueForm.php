<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyValueForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['config'] as $field) {
            $builder->add($field['name'], TextType::class, [
                'label' => $field['label'],
                'attr' => array('placeholder' => $field['placeholder'])]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('config');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_bundle_key_value_form';
    }

}
