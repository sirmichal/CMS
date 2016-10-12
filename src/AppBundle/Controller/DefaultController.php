<?php

namespace AppBundle\Controller;

use AppBundle\Form\FileUploadForm;
use AppBundle\Entity\Media;
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
    public function usersAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('form.html.twig', array('users' => $users));
    }

    /**
     * @Route("delete/{userId}", name="delete_user", requirements={"userId": "\d+"})
     * @param $userId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($userId)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userId));
        $userManager->deleteUser($user);
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
    public function uploadAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm(FileUploadForm::class, $media);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();
            return $this->redirect($this->generateUrl('media_library'));
        }
        return $this->render('upload.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("media/library", name="media_library")
     */
    public function mediaLibraryAction(Request $request) {
        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Media')->findAll();
        
        return $this->render('media_library.html.twig', array('files' => $mediaFiles));
    }
    

    /**
     * @Route("media/delete", name="delete_media")
     */
    public function deleteMediaAction(Request $request) {
        $json = $request->get('data');
        $json = html_entity_decode($json);
        $names = json_decode($json);
        
        $mediaRepo = $this->getDoctrine()->getRepository('AppBundle:Media');
        $em = $this->getDoctrine()->getManager();
        
        foreach ($names as $name)
        {
            $file = $mediaRepo->findOneBy(array('name' => $name));
            $em->remove($file);
            $em->flush();
        }

        return new Response('OK');
    }
    

    /**
     * @param Request $request
     * @return Response
     * @Route("footer", name="footer")
     */
    public function footerAction(Request $request)
    {
        $footerHandler = $this->get("footer_handler");
        $form = $footerHandler->createForm();
        $footerHandler->submit($request);

        return $this->render('footer.html.twig', array('form' => $form->createView()));
    }

}
