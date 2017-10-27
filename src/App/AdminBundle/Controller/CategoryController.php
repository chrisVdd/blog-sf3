<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 17/10/17
 * Time: 18:27
 */

namespace App\AdminBundle\Controller;

use App\AdminBundle\Form\CategoryType;
use App\MainBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package App\AdminBundle\Controller
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="admin_category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Category[] $categories */
        $categories = $entityManager->getRepository('AppMainBundle:Category')->findAll();

        return $this->render('@AppAdmin/category/index.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="admin_category_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        /** @var Category $category */
        $category = new Category();

        /** @var Form $form */
        $form = $this->get('form.factory')->create(CategoryType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien enregistrée');

            return $this->redirectToRoute('admin_category_show', ['id' => $category->getId()]);
        }

        return $this->render('@AppAdmin/category/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="admin_category_show")
     * @Method("GET")
     *
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Category $category)
    {
        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('@AppAdmin/category/new.html.twig',
            [
                'category' => $category,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="admin_category_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Category $category)
    {
        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($category);

        /** @var Form $editForm */
        $editForm = $this->createForm('App\MainBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }

        return $this->render('@AppAdmin/category/edit.html.twig',
            [
                'category' => $category,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="admin_category_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        /** @var Form $form */
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_category_delete', ['id' => $category->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}