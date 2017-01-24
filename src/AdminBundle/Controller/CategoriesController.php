<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Category;
use AdminBundle\Form\NewCategoryForm;

class CategoriesController extends Controller {

    /**
     * @Route("categories", name="categories")
     * @return Response
     */
    public function indexAction() {
        $categories = $this->getDoctrine()->getRepository('AdminBundle:Category')->findAll();
        $form = $this->createForm(NewCategoryForm::class, null, array(
            'action' => $this->generateUrl('categories_add')
        ));
        
        return $this->render('AdminBundle:Categories:categories.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView()));
    }
    
    /**
     * @Route("category", name="categories_add")
     */
    public function newCategoryAction(Request $request) {
        $name = $request->request->get('new_category_form')['category'];
        if (null != $name) {
            $category = new Category();
            $category->setCategory($name);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("category/delete/{id}", name="categories_delete", requirements={"id": "\d+"})
     * @param $id
     * @return Response
     */
    public function deleteAction($id) {
        $repo = $this->getDoctrine()->getRepository('AdminBundle:Category');
        $category = $repo->findOneById($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('categories');
    }
    
    /**
    * @Route("category/{id}", name="categories_edit", requirements={"id": "\d+"})
    * @param Request $request
    * @param $id
    * @return Response
    */
    public function editAction(Request $request, $id) {
        $repo = $this->getDoctrine()->getRepository('AdminBundle:Category');
        $category = $repo->findOneById($id);
        $form = $this->createForm(NewCategoryForm::class, $category);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $category->setCategory($form->get('category')->getData());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('categories');
        }
        
        $categories = $repo->findAll();

        return $this->render('AdminBundle:Categories:categories.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView()));
    }
}
