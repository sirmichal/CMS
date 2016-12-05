<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class NewPostForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
            'label' => 'Tytuł:',
            'attr' => array('placeholder' => 'Wpisz tytuł')]);

        $builder->add('content', TextareaType::class, [
            'label' => 'Treść:',
            'attr' => array('placeholder' => 'Wpisz treść')]);

        $builder->add('thumbId', HiddenType::class, array(
            'mapped' => false, 'label' => false)); 
        
        $builder->add('categories', EntityType::class, array(
            'label' => 'Kategorie:',
            'class' => 'AdminBundle:Category',
            'choice_label' => 'category',
            'expanded' => true,
            'multiple' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                                ->orderBy('c.category', 'ASC');
            },
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'AdminBundle\Entity\Post']);
    }

    public function getName() {
        return 'app_bundle_footer_form';
    }

}
