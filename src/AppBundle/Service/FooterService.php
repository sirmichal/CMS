<?php

namespace AppBundle\Service;

use AppBundle\Form\FooterForm;
use AppBundle\FooterHandler;
use Symfony\Component\Form\FormFactory;
use Doctrine\Bundle\DoctrineBundle\Registry;

class FooterService {
    
    private $factoryForm;
    private $doctrine;

    public function __construct(FormFactory $factoryForm, Registry $doctrine) {
        $this->factoryForm = $factoryForm;
        $this->doctrine = $doctrine;
    }
    
    public function createForm() {
        $footerArray = $this->doctrine->getRepository('AppBundle:Footer')->findAll();
        $footerHandler = new FooterHandler($footerArray);
        $form = $this->factoryForm->create(FooterForm::class, $footerHandler);
        return $form;
    }
}
