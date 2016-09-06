<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Footer;
use AppBundle\Form\NewUserForm;
use AppBundle\Form\FooterForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Request $request
     * @return Response
     * @Route("footer", name="footer")
     */
    public function footerAction(Request $request)
    {
        $form = $this->createForm(FooterForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $street = new Footer();
            $street->setAttr('street');
            $street->setValue($data['street']);

            $city = new Footer();
            $city->setAttr('city');
            $city->setValue($data['city']);

            $phone_number = new Footer();
            $phone_number->setAttr('phone_number');
            $phone_number->setValue($data['phone_number']);

            $postal_code = new Footer();
            $postal_code->setAttr('postal_code');
            $postal_code->setValue($data['postal_code']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($street);
            $em->persist($city);
            $em->persist($phone_number);
            $em->persist($postal_code);

            $em->flush();

            return $this->redirectToRoute('footer');
        }

        return $this->render('footer.html.twig', array('form' => $form->createView()));
    }

}
