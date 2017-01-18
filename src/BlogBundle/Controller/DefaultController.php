<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $posts = $this->doctrine->getRepository('AdminBundle:Post')->findAll();
        $categories = $this->getCategoriesData();
        $subscribeEmailForm = $this->createSubscribeEmailForm();

        return $this->render('BlogBundle::index.html.twig', array(
            'literals' => $this->get("key_value_form")->getData('literals'),
            'categories' => $categories,
            'form' => $subscribeEmailForm->createView(),
            'posts' => $posts
        ));
    }

    /**
     * @Route("/category/{id}", name="category", requirements={"id": "\d+"} )
     * @param $id
     * @return Response
     */
    public function categoryAction($id)
    {
        $this->doctrine = $this->getDoctrine();
        $qb = $this->doctrine->getRepository('AdminBundle:Post')->createQueryBuilder('p');
        $posts = $qb->join('p.categories', 'c', 'WITH', 'c.id = :id')->setParameter('id', $id)->getQuery()->getResult();
        $categories = $this->getCategoriesData();
        $subscribeEmailForm = $this->createSubscribeEmailForm();

        return $this->render('BlogBundle::index.html.twig', array(
            'literals' => $this->get("key_value_form")->getData('literals'),
            'categories' => $categories,
            'form' => $subscribeEmailForm->createView(),
            'posts' => $posts
        ));
    }

    /**
     * @Route("/post/{id}", name="post", requirements={"id": "\d+"} )
     * @param $id
     * @return Response
     */
    public function postAction($id)
    {
        $this->doctrine = $this->getDoctrine();
        $post = $this->doctrine->getRepository('AdminBundle:Post')->findOneById($id);
        $categories = $this->getCategoriesData();
        $subscribeEmailForm = $this->createSubscribeEmailForm();

        return $this->render('BlogBundle::post.html.twig', array(
            'literals' => $this->get("key_value_form")->getData('literals'),
            'categories' => $categories,
            'form' => $subscribeEmailForm->createView(),
            'post' => $post
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
            $entry['id'] = $c->getId();
            $entry['name'] = $c->getCategory();
            $entry['posts_counter'] = $c->getPosts()->count();
            $categories[] = $entry;
        }

        return $categories;
    }

}
