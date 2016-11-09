<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository('AdminBundle:Footer');

        $query = $repo->createQueryBuilder('f')->select('f.attr, f.value')->getQuery();
        $result = $query->getResult();
        $footer = $this->formatDoctrineResult($result);
        
        $sliders = $doctrine->getRepository('AdminBundle:Slider')->findAll();

        return $this->render('BlogBundle:Default:index.html.twig', array('f' => $footer, 'sliders' => $sliders));
    }
    
    
    private function formatDoctrineResult($doctrineResult) {
        $attrs = array_map(function($value) { return $value['attr']; }, $doctrineResult);
        $values = array_map(function($value) { return $value['value']; }, $doctrineResult);
        $output = array_combine($attrs, $values);
        return $output;
    }
}
