<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class SubscriberForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', EmailType::class, [
            'label' => false,
            'attr' => array('placeholder' => 'Wpisz swój email')]);
    }

    public function getName() {
        return 'blog_bundle_subscriber_form';
    }

}
