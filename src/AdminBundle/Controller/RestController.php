<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;

use AdminBundle\Repository\MediaRepository;

class RestController extends FOSRestController 
{
    public function getCategoriesAction() {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Category')->findAll();
        return $this->getFilteredView($result, ['category', 'Default']);
    }
    
    public function getCategoryAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Category')->findOneById($id);
        return $this->getFilteredView($result, ['category', 'Default']);
    }

    public function getPostsAction() {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Post')->findAll();
        return $this->getFilteredView($result, ['post', 'Default']);
    }
    
    public function getPostAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Post')->findOneById($id);
        return $this->getFilteredView($result, ['post', 'Default']);
    }
    
    public function getImageAction($id) {
        $result = $this->getDoctrine()->getRepository('AdminBundle:Media')->findOneById($id);
        return $this->getFilteredView($result, ['media', 'details', 'Default']);
    }
    
    public function deleteImageAction($id) {
        return new Response();
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
