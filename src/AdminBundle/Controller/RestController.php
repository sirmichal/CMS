<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;

class RestController extends FOSRestController 
{
    public function getCategoriesAction() {
        $entityMngr = $this->get('entity_manager');
        $entityMngr->setEntityClassName('AdminBundle:Category');
        $result = $entityMngr->findAll();
        return $this->getFilteredView($result, ['categories']);
    }
    
    public function getCategoryAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Category')->findOneById($id);
        return $this->getFilteredView($result, ['single_category']);
    }

    public function getPostsAction() {
        $entityMngr = $this->get('entity_manager');
        $entityMngr->setEntityClassName('AdminBundle:Post');
        $result = $entityMngr->findAll();
        return $this->getFilteredView($result, ['posts']);
    }
    
    public function getPostAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Post')->findOneById($id);
        return $this->getFilteredView($result, ['single_post']);
    }
    
    public function getMediaAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Media')->findOneById($id);
        return $this->getFilteredView($result, ['single_media']);
    }

    public function getLiteralsAction() {
        $entityMngr = $this->get('entity_manager');
        $entityMngr->setEntityClassName('AdminBundle:KeyValue');
        $result = $entityMngr->findAll();
        return $this->getFilteredView($result, ['keys_values']);
    }

    public function getLiteralAction($attr) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:KeyValue')->findOneByAttr($attr);
        return $this->getFilteredView($result, ['single_key_value']);
    }

    public function deleteMediaAction($id) {
        $entityMngr = $this->get('entity_manager');
        $entityMngr->setEntityClassName('AdminBundle:Media');
        $responseCode = $entityMngr->deleteOne($id, 'id');
        return $this->view(null, $responseCode);
    }
    
    public function postSubscribersAction(Request $request) {
        $json = $request->getContent();
        $entity = $this->get('jms_serializer')->deserialize($json, 'BlogBundle\Entity\Subscriber', 'json');
        $entityMngr = $this->get('entity_manager');
        $responseCode = $entityMngr->persist($entity);
        return $this->view(null, $responseCode);
    }

    protected function getFilteredView($data, $groups) {
        $view = null;
        if (null == $data) {
            $view = new View("null data", Response::HTTP_NOT_FOUND);
        } else {
            $view = $this->view($data, Response::HTTP_OK);
            $context = new Context();
            $context->addGroups($groups);
            $view->setContext($context);
        }
        return $view;
    }
    
}
