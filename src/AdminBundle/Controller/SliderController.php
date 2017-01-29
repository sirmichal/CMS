<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Slider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{

    /**
     * @Route("slider", name="slider")
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository('AdminBundle:Media')->createQueryBuilder('m');
        $query = $qb->where('m.sliders IS EMPTY')->getQuery();
        $media = $query->getResult();

        $slider = $em->getRepository('AdminBundle:Slider')->findAll();

        return $this->render('AdminBundle:Slider:slider.html.twig', array('media' => $media, 'slider' => $slider));
    }

    /**
     * @Route("slider/modal/add-img/submit", name="slider_modal_add_img_submit")
     * @param Request $request
     * @return Response
     */
    public function modalAddImgSubmitAction(Request $request)
    {
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

        return new Response();
    }

    /**
     * @return Response
     * @Route("slider/modal/add-img/render", name="slider_modal_add_img_render")
     */
    public function modalAddImgRenderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AdminBundle:Media')->createQueryBuilder('m');
        $query = $qb->where('m.sliders IS EMPTY')->getQuery();
        $media = $query->getResult();

        $view = $this->renderView('AdminBundle:Modal/Slider:slider.html.twig', array(
            'media' => $media));
        return new Response($view);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("slider/delete-img", name="slider_delete_img")
     */
    public function deleteImgAction(Request $request)
    {
        $ids = json_decode(html_entity_decode($request->request->get('ids')));
        $em = $this->getDoctrine()->getManager();
        $sliderRepo = $em->getRepository('AdminBundle:Slider');

        foreach ($ids as $id) {
            $slider = $sliderRepo->findOneByMedia($id);
            $em->remove($slider);
        }

        $em->flush();

        return new Response();
    }

}
