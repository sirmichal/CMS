<?php

namespace AdminBundle\Service;

use AdminBundle\Entity\Footer;
use AdminBundle\Form\FooterForm;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

    private $config;
    
    private $footerEntities;
    
    private $data;

    /**
     * FooterService constructor.
     * @param FormFactory $factoryForm
     * @param Registry $doctrine
     * @param Session $session
     * @param ContainerInterface $container
     */
    public function __construct(FormFactory $factoryForm, Registry $doctrine, Session $session, ContainerInterface $container)
    {
        $this->factoryForm = $factoryForm;
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->repo = $this->doctrine->getManager()->getRepository('AdminBundle:Footer');
        $this->config = $container->getParameter('admin')['footer_form'];
        
        $this->readDataFromDb();
    }

    /**
     * @return Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm()
    {
        $this->form = $this->factoryForm->create(FooterForm::class, null, array('footer_service' => $this));
        
        foreach ($this->footerEntities as $ent) {
            $attr = $ent->getAttr();
            $value = $ent->getValue();

            $this->form->get($attr)->setData($value);
        }
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
        
        foreach ($this->config as $field) {
            $em->createQuery('DELETE FROM AdminBundle:Footer')->execute();
            
            $attr = $field['name'];
            $value = $formData[$attr];
            $ent = new Footer($attr, $value);
            $em->persist($ent);
        }
        $em->flush();
    }

    private function readDataFromDb()
    {
        foreach ($this->config as $field) {
            $attr = $field['name'];
            $ent = $this->repo->findOneByAttr($attr);
            if (null == $ent) {
                $ent = new Footer($attr);
            }
            $this->footerEntities[$attr] = $ent;
            $this->data[$attr] = $ent->getValue();
        }
    }

    public function getConfig() {
        return $this->config;
    }
    
    public function getData() {
        return $this->data;
    }
}
