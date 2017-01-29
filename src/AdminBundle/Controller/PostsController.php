<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Post;
use AdminBundle\Form\NewPostForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{

    /**
     * @Route("posts/add", name="posts_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(NewPostForm::class, $post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $thumbnailId = $form->get('thumbId')->getData();
            $thumbnail = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($thumbnailId);

            $post->setThumbnail($thumbnail);
            $post->setCreated(new \DateTime('now'));
            $post->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('posts_add');
        }

        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();

        return $this->render('AdminBundle:Posts:add.html.twig', array('form' => $form->createView(), 'images' => $mediaFiles));
    }

    /**
     * @Route("posts", name="posts")
     * @return Response
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('AdminBundle:Post')->findAll();
        return $this->render('AdminBundle:Posts:posts.html.twig', array('posts' => $posts));
    }

    /**
     * @Route("posts/delete/{id}", name="posts_delete", requirements={"id": "\d+"})
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('AdminBundle:Post');
        $post = $repo->findOneById($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('posts');
    }

    /**
     * @Route("posts/{id}", name="posts_edit", requirements={"id": "\d+"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editPostAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository('AdminBundle:Post')->findOneById($id);
        $form = $this->createForm(NewPostForm::class, $post);

        $thumbnail = $post->getThumbnail();
        if ($thumbnail != null) {
            $form->get('thumbId')->setData($thumbnail->getId());
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $thumbnailId = $form->get('thumbId')->getData();
            $thumbnail = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findOneById($thumbnailId);

            $post->setThumbnail($thumbnail);
            $post->setUser($this->getUser());

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('posts');
        }

        $mediaFiles = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();

        return $this->render('AdminBundle:Posts:add.html.twig', array('form' => $form->createView(), 'images' => $mediaFiles, 'thumb' => $thumbnail));
    }

    /**
     * @return Response
     * @Route("posts/modal/add-img/render", name="posts_modal_add_img_render")
     */
    public function modalAddImgRenderAction()
    {
        $media = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Media')->findAll();
        $view = $this->renderView('AdminBundle:Modal/Posts:add.html.twig', array(
            'media' => $media));
        return new Response($view);
    }

}
