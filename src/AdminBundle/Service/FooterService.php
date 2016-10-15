<?php

namespace AdminBundle\Service;

use AdminBundle\Entity\Footer;
use AdminBundle\Form\FooterForm;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class FooterService
{

    /**
     * @var FormFactory
     */
    private $factoryForm;

    /**
     * @var Registry
     */
    private $doctrine;
    
    /**
     * @var Session
     */
    private $session;

    /**
     * @var \AdminBundle\Repository\FooterRepository
     */
    private $repo;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var Footer
     */
    private $streetEnt;
    /**
     * @var Footer
     */
    private $cityEnt;
    /**
     * @var Footer
     */
    private $phoneNumEnt;
    /**
     * @var Footer
     */
    private $postalCodeEnt;

    /**
     * FooterService constructor.
     * @param FormFactory $factoryForm
     * @param Registry $doctrine
     */
    public function __construct(FormFactory $factoryForm, Registry $doctrine, Session $session)
    {
        $this->factoryForm = $factoryForm;
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->repo = $this->doctrine->getManager()->getRepository('AdminBundle:Footer');
    }

    /**
     * @return Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm()
    {
        $this->readDataFromDb();

        $this->form = $this->factoryForm->create(FooterForm::class);
        $this->form->setData([
            'street' => $this->streetEnt->getValue(),
            'city' => $this->cityEnt->getValue(),
            'phoneNum' => $this->phoneNumEnt->getValue(),
            'postalCode' => $this->postalCodeEnt->getValue()
        ]);
        return $this->form;
    }

    /**
     * @param Request $request
     */
    public function submit(Request $request)
    {
        $this->form->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->saveDataToDb();
            $this->session->getFlashBag()->add('success', 'Zaktualizowano dane');
        }
    }

    private function saveDataToDb()
    {
        $em = $this->doctrine->getManager();

        $formData = $this->form->getData();
        $this->streetEnt->setValue($formData['street']);
        $this->cityEnt->setValue($formData['city']);
        $this->phoneNumEnt->setValue($formData['phoneNum']);
        $this->postalCodeEnt->setValue($formData['postalCode']);

        $em->flush();
    }

    private function readDataFromDb()
    {
        $this->streetEnt = $this->repo->findOneByAttr('street');
        $this->cityEnt = $this->repo->findOneByAttr('city');
        $this->phoneNumEnt = $this->repo->findOneByAttr('phone_number');
        $this->postalCodeEnt = $this->repo->findOneByAttr('postal_code');
    }
}
