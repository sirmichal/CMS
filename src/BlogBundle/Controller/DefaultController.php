<?php

namespace BlogBundle\Controller;

use AdminBundle\Entity\Footer;
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
        $attrs = array_map(function($value) { return $value['attr']; }, $result);
        $values = array_map(function($value) { return $value['value']; }, $result);
        $output = array_combine($attrs, $values);

        return $this->render('BlogBundle:Default:index.html.twig', $output);
    }
}
