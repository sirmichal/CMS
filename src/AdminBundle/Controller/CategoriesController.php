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
            'action' => $this->generateUrl('new_category')
        ));
        
        return $this->render('AdminBundle:Categories:categories.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView()));
    }
    
    /**
     * @Route("category", name="new_category")
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
     * @Route("category/{id}/delete", name="delete_category", requirements={"id": "\d+"})
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

}
