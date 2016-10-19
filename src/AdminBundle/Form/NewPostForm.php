<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewPostForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
            'label' => 'Tytuł:',
            'attr' => array('placeholder' => 'Wpisz tytuł')]);

        $builder->add('content', TextareaType::class, [
            'label' => 'Treść:',
            'attr' => array('placeholder' => 'Wpisz treść')]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'AdminBundle\Entity\Post']);
    }

    public function getName() {
        return 'app_bundle_footer_form';
    }

}
