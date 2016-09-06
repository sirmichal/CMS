<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FooterForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('street', TextType::class, [
            'label' => 'Ulica:',
            'attr' => array('placeholder' => 'Wpisz ulicę')]);
        
        $builder->add('city', TextType::class, [
            'label' => 'Miasto:',
            'attr' => array('placeholder' => 'Wpisz miejscowość')]);
        
        $builder->add('postal_code', TextType::class, [
            'label' => 'Kod pocztowy:',
            'attr' => array('placeholder' => 'Wpisz kod pocztowy')]);
        
        $builder->add('phone_number', TextType::class, [
            'label' => 'Nr telefonu:',
            'attr' => array('placeholder' => 'Wpisz nr telefonu')]);
    }

    public function configureOptions(OptionsResolver $resolver) {
//        $resolver->setDefaults(['data_class' => 'AppBundle\Form\FooterForm']);
    }

    public function getName() {
        return 'app_bundle_footer_form';
    }

}
