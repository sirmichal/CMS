<?php

namespace AdminBundle\Service;

use AdminBundle\Entity\KeyValue;
use AdminBundle\Form\KeyValueForm;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KeyValueFormService
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
     * @var \AdminBundle\Repository\KeyValueRepository
     */
    private $repo;

    /**
     * @var Form
     */
    private $form;

    private $container;

    private $config;

    private $entities;

    private $data;

    private $formType;

    /**
     * KeyValueFormService constructor.
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
        $this->container = $container;
        $this->repo = $this->doctrine->getManager()->getRepository('AdminBundle:KeyValue');
    }

    /**
     * @return Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm()
    {
        $this->form = $this->factoryForm->create(KeyValueForm::class, null, array('config' => $this->config));

        foreach ($this->entities as $ent) {
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
            $this->repo->createQueryBuilder('f')
                    ->delete()
                    ->where('f.form = :form')
                    ->setParameter('form', $this->formType)
                    ->getQuery()
                    ->execute();

            $attr = $field['name'];
            $value = $formData[$attr];
            $ent = new KeyValue($this->formType, $attr, $value);
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
                $ent = new KeyValue($this->formType, $attr);
            }
            $this->entities[$attr] = $ent;
            $this->data[$attr] = $ent->getValue();
        }
    }

    public function getConfig() {
        return $this->config;
    }

    public function getData($formType) {
        $this->setFormType($formType);
        return $this->data;
    }

    public function setFormType($formType) {
        $this->formType = $formType;
        $this->config = $this->container->getParameter('admin')['forms'][$formType];
        $this->readDataFromDb();
    }
}
