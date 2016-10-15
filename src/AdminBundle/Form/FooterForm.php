<?php

namespace AdminBundle\Form;

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
        
        $builder->add('postalCode', TextType::class, [
            'label' => 'Kod pocztowy:',
            'attr' => array('placeholder' => 'Wpisz kod pocztowy')]);
        
        $builder->add('phoneNum', TextType::class, [
            'label' => 'Nr telefonu:',
            'attr' => array('placeholder' => 'Wpisz nr telefonu')]);
    }

    public function getName() {
        return 'app_bundle_footer_form';
    }

}