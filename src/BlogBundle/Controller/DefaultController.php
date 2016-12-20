<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Form\SubscriberForm;
use BlogBundle\Entity\Subscriber;

class DefaultController extends Controller
{
    private $doctrine;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $this->doctrine = $this->getDoctrine();
        $sliders = $this->doctrine->getRepository('AdminBundle:Slider')->findAll();
        $posts = $this->doctrine->getRepository('AdminBundle:Post')->findAll();

        $categories = $this->getCategoriesData();

        $subscribeEmailForm = $this->createSubscribeEmailForm();

        return $this->render('BlogBundle::index.html.twig', array(
            'footer' => $this->get("footer_service")->getData(),
            'sliders' => $sliders,
            'categories' => $categories,
            'form' => $subscribeEmailForm->createView(),
            'posts' => $posts
        ));
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
     * @param Request $request
     * @return RedirectResponse
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

    private function getCategoriesData() {
        $categoryEntities = $this->doctrine->getRepository('AdminBundle:Category')->findAll();

        $categories = array();
        foreach($categoryEntities as $c) {
            $entry['name'] = $c->getCategory();
            $entry['posts_counter'] = $c->getPosts()->count();
            $categories[] = $entry;
        }

        return $categories;
    }

}
