<?php

namespace AppBundle\Controller;

use AppBundle\Form\NewUserForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Name;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("users", name="users")
     * @param Request $request
     * @return Response
     */
    public function usersAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')
            ->createQueryBuilder('u')->getQuery()->getResult();

        $form = $this->createForm(NewUserForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->addFlash('success', 'User created!');

            return $this->redirectToRoute('users');
        }


        return $this->render('form.html.twig', array('users' => $users, 'form' => $form->createView()));
    }

    /**
     * @Route("delete/{userId}", name="delete_user", requirements={"userId": "\d+"})
     * @param $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($userId)
    {
        $qb = $this->getDoctrine()->getRepository('AppBundle:User')->createQueryBuilder('u');


        $qb->delete();
        $qb->where('u.id = :id');
        $qb->setParameter('id', $userId);
        $qb->getQuery()->getResult();
        
        $this->addFlash('delete', 'User deleted!');

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("home", name="home")
     */
    public function homeAction()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("upload", name="upload")
     */
    public function uploadAction()
    {
        return $this->render('upload.html.twig');
    }

    /**
     * @return Response
     */
    public function makeAction()
    {
        // create a task and give it some dummy data for this example
        $name = new Name();
        $form = $this->createFormBuilder($name)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Zapisz'))
            ->getForm();

        return $this->render('form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
