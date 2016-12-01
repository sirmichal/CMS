<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BlogBundle\Form\SubscriberForm;
use BlogBundle\Entity\Subscriber;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
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
        
        $form = $this->createSubscribeEmailForm();

        return $this->render('BlogBundle::index.html.twig', array(
            'f' => $footer,
            'sliders' => $sliders,
            'lastPost' => $lastPost,
            'form' => $form->createView()));
    }
    
    
    private function formatDoctrineResult($doctrineResult) {
        $attrs = array_map(function($value) { return $value['attr']; }, $doctrineResult);
        $values = array_map(function($value) { return $value['value']; }, $doctrineResult);
        $output = array_combine($attrs, $values);
        return $output;
    }
    
    private function createSubscribeEmailForm() {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberForm::class, $subscriber, array(
            'action' => $this->generateUrl('new_subscriber')
        ));
        return $form;
    }
    
    /**
     * @Route("/subscriber", name="new_subscriber")
     */
    public function newSubscriberAction(Request $request) {
        $email = $request->request->get('subscriber_form')['email'];
        if(null != $email) {
            $subscriber = new Subscriber();
            $subscriber->setEmail($email);
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }

}
