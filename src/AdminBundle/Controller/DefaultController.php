<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Media;
use AdminBundle\Form\FileUploadForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route(name="admin_homepage")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:home.html.twig');
    }

    /**
     * @Route("settings", name="settings")
     * @return Response
     */
    public function settingsAction()
    {
        return $this->redirectToRoute('admin_homepage');
    }

    /**
     * @Route("users", name="users")
     * @return Response
     */
    public function usersAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('AdminBundle:Default:users.html.twig', array('users' => $users));
    }

    /**
     * @Route("delete/{userId}", name="delete_user", requirements={"userId": "\d+"})
     * @param $userId
     * @return RedirectResponse
     */
    public function deleteAction($userId)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userId));
        $userManager->deleteUser($user);

        return $this->redirectToRoute('fos_user_security_logout');
    }

    /**
     * @Route("upload", name="upload")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function uploadAction(Request $request)
    {
        $media = new Media();
        $form = $this->createForm(FileUploadForm::class, $media);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('media_library');
        }
        return $this->render('AdminBundle:Default:upload.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("media/library", name="media_library")
     */
    public function mediaLibraryAction()
    {
        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();

        return $this->render('AdminBundle:Default:media_library.html.twig', array('files' => $mediaFiles));
    }

    /**
     * @Route("media/delete/{mediaId}", name="delete_media", requirements={"mediaId": "\d+"})
     * @return Response
     */
    public function deleteMediaAction($mediaId)
    {
        $mediaRepo = $this->getDoctrine()->getRepository('AdminBundle:Media');
        $media = $mediaRepo->findOneById($mediaId);

        $cacheMngr = $this->get('liip_imagine.cache.manager');
        $cacheMngr->remove('media/' . $media->getName());

        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();

        return $this->redirectToRoute('media_library');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("literals", name="literals")
     */
    public function literalsAction(Request $request)
    {
        $keyValueFormService = $this->get('key_value_form');
        $keyValueFormService->setFormType('literals');
        $form = $keyValueFormService->createForm();
        $keyValueFormService->submit($request);

        return $this->render('AdminBundle:Default:literals.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("getModal", name="get_modal")
     */
    public function getModalAction(Request $request)
    {
        $id = $request->query->get('id');

        /** @var Media $media */
        $media = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($id);

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $preview_path = $imagineCacheManager->getBrowserPath('media/' . $media->getName(), 'single_image');

        $rawInfo = getimagesize('media/' . $media->getName());
        $info['width'] = $rawInfo[0];
        $info['height'] = $rawInfo[1];
        $info['mime'] = $rawInfo['mime'];
        $info['size'] = filesize('media/' . $media->getName());

        $view = $this->renderView('AdminBundle:Modal/Media:library.html.twig',
            array(
                'media' => $media,
                'info' => $info,
                'preview_path' => $preview_path));
        return new Response($view);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("media/cache", name="get_media_specific_cache")
     */
    public function getMediaSpecificCacheAction(Request $request)
    {
        $id = $request->query->get('id');
        $filter = $request->query->get('filter');

        $media = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($id);

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $preview_path = $imagineCacheManager->getBrowserPath('media/' . $media->getName(), $filter);

        return new Response($preview_path);
    }

}
