<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FileUploadForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('file', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Media']);
    }

    public function getName() {
        return 'app_bundle_file_upload_form';
    }

}
