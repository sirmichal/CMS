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

        $qb = $doctrine->getRepository('AdminBundle:Post')->createQueryBuilder('p');
        $query = $qb->orderBy('p.id', 'DESC')->setMaxResults(1)->getQuery();
        $lastPost = $query->getSingleResult();
        
        return $this->render('BlogBundle::index.html.twig', array(
            'f' => $footer,
            'sliders' => $sliders,
            'lastPost' => $lastPost));
    }
    
    
    private function formatDoctrineResult($doctrineResult) {
        $attrs = array_map(function($value) { return $value['attr']; }, $doctrineResult);
        $values = array_map(function($value) { return $value['value']; }, $doctrineResult);
        $output = array_combine($attrs, $values);
        return $output;
    }
}
