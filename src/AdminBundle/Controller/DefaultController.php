<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\FileUploadForm;
use AdminBundle\Form\NewPostForm;
use AdminBundle\Entity\Media;
use AdminBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("posts/new", name="add_new_post")
     * @param Request $request
     * @return Response
     */
    public function addNewPostAction(Request $request) {
        $post = new Post();
        $form = $this->createForm(NewPostForm::class, $post);
        $form->handleRequest($request);

        if($form->isValid()) {
            $thumbnailId = $form->get('thumbId')->getData();
            $thumbnail = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($thumbnailId);

            $post->setThumbnail($thumbnail);
            $post->setCreated(new \DateTime('now'));
            $post->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('add_new_post');
        }
        
        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();

        return $this->render('AdminBundle:Post:add.html.twig', array('form' => $form->createView(), 'images' => $mediaFiles));
    }

    /**
     * @Route("posts", name="show_posts")
     * @return Response
     */
    public function showPostsAction() {
        $posts = $this->getDoctrine()->getRepository('AdminBundle:Post')->findAll();
        return $this->render('AdminBundle:Post:show.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("posts/delete/{postId}", name="delete_post", requirements={"postId": "\d+"})
     * @param $postId
     * @return Response
     */
    public function deletePostAction($postId) {
        $repo = $this->getDoctrine()->getRepository('AdminBundle:Post');
        $post = $repo->findOneById($postId);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('show_posts');
    }

    /**
     * @Route("posts/{postId}", name="edit_post", requirements={"postId": "\d+"})
     * @param Request $request
     * @param $postId
     * @return Response
     */
    public function editPostAction(Request $request, $postId) {
        
        $post = $this->getDoctrine()->getRepository('AdminBundle:Post')->findOneById($postId);
        $form = $this->createForm(NewPostForm::class, $post);
        
        $thumbnail = $post->getThumbnail();
        if($thumbnail != null) {
            $form->get('thumbId')->setData($thumbnail->getId());
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $thumbnailId = $form->get('thumbId')->getData();
            $thumbnail = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($thumbnailId);

            $post->setThumbnail($thumbnail);
            $post->setUser($this->getUser());

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('show_posts');
        }
        
        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();
        
        return $this->render('AdminBundle:Post:add.html.twig', array('form' => $form->createView(), 'images' => $mediaFiles, 'thumb' => $thumbnail));
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
     * @Route("upload", name="upload")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
        return $this->render('AdminBundle:Default:upload.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("media/library", name="media_library")
     */
    public function mediaLibraryAction() {
        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();
        
        return $this->render('AdminBundle:Default:media_library.html.twig', array('files' => $mediaFiles));
    }

    /**
     * @Route("media/delete/{mediaId}", name="delete_media", requirements={"mediaId": "\d+"})
     * @return Response
     */
    public function deleteMediaAction($mediaId) {
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
     * @Route("footer", name="footer")
     */
    public function footerAction(Request $request)
    {
        $footerHandler = $this->get("footer_handler");
        $form = $footerHandler->createForm();
        $footerHandler->submit($request);

        return $this->render('AdminBundle:Default:footer.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("getModal", name="get_modal")
     */
    public function getModalAction(Request $request) {
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
                    'media'         => $media,
                    'info'          => $info,
                    'preview_path'  => $preview_path));
        return new Response($view);
    }

    /**
     * @return Response
     * @Route("modal/post", name="modal_post")
     */
    public function modalPostAction() {
        $media = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();
        $view = $this->renderView('AdminBundle:Modal/Post:add.html.twig',
            array(
                'media'         => $media));
        return new Response($view);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("media/cache", name="get_media_specific_cache")
     */
    public function getMediaSpecificCacheAction(Request $request) {
        $id = $request->query->get('id');
        $filter = $request->query->get('filter');

        $media = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($id);

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $preview_path = $imagineCacheManager->getBrowserPath('media/' . $media->getName(), $filter);

        return new Response($preview_path);
    }

}
