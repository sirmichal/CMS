<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FooterForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $footer = $options['footer_service'];
        
        foreach ($footer->getConfig() as $field) {
            $builder->add($field['name'], TextType::class, [
                'label' => $field['label'],
                'attr' => array('placeholder' => $field['placeholder'])]);
        }
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired('footer_service');
    }

    public function getName() {
        return 'admin_bundle_footer_form';
    }

}
