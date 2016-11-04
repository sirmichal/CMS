<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Slider;
use AdminBundle\Entity\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller {

    /**
     * @Route("slider",name="slider")
     * @return Response
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $mediaRepo = $em->getRepository('AdminBundle:Media')->findAll();
        $sliderRepo = $em->getRepository('AdminBundle:Media')->findAll();
        return $this->render('AdminBundle:Slider:slider.html.twig', array('media' => $mediaRepo, 'slider' => $sliderRepo));
    }
    
    
    /**
     * @Route("slider/save",name="save_slider")
     * @return Response
     */
    public function saveAction(Request $request) {
        $ids = json_decode(html_entity_decode($request->request->get('ids')));
        $em = $this->getDoctrine()->getManager();
        $mediaRepo = $em->getRepository('AdminBundle:Media');
        
        foreach ($ids as $id) {
            $slider = new Slider();
            $media = $mediaRepo->findOneById($id);
            $slider->setMedia($media);
            $em->persist($slider);
        }
        
        $em->flush();
        
        
        return new Response(implode($ids));
    }

}
