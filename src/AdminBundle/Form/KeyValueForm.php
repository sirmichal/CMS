<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class KeyValueForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        foreach ($options['config'] as $field) {
            $builder->add($field['name'], TextType::class, [
                'label' => $field['label'],
                'attr' => array('placeholder' => $field['placeholder'])]);
        }
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired('config');
    }

    public function getName() {
        return 'admin_bundle_key_value_form';
    }

}
