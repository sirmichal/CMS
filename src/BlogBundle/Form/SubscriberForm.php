<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriberForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'label' => false,
            'attr' => array('placeholder' => 'Wpisz swój email')]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blog_bundle_subscriber_form';
    }

}
