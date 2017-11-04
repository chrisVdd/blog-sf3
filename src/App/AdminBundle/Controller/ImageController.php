<?php

namespace App\AdminBundle\Controller;

use App\MainBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Image controller.
 *
 * @Route("image")
 */
class ImageController extends Controller
{
    /**
     * Lists all image entities.
     *
     * @Route("/", name="admin_image_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AppMainBundle:Image')->findAll();

        return $this->render('@AppAdmin/image/index.html.twig',
            [
                'images' => $images,
            ]
        );
    }

    /**
     * Creates a new image entity.
     *
     * @Route("/new", name="admin_image_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        /** @var Image $image */
        $image = new Image();

        /** @var Form $form */
        $form = $this->createForm('App\AdminBundle\Form\ImageType', $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('image_show',
                ['id' => $image->getId()]
            );
        }

        return $this->render('AppAdminBundle:image:new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a image entity.
     *
     * @Route("/{id}", name="admin_image_show")
     * @Method("GET")
     */
    public function showAction(Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('@AppAdmin/image/show.html.twig',
            [
                'image' => $image,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing image entity.
     *
     * @Route("/{id}/edit", name="admin_image_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);
        $editForm = $this->createForm('App\MainBundle\Form\ImageType', $image);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_image_edit', ['id' => $image->getId()]);
        }

        return $this->render('@AppAdmin/image/edit.html.twig',
            [
                'image' => $image,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a image entity.
     *
     * @Route("/{id}", name="admin_image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Image $image)
    {
        $form = $this->createDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_image_index');
    }

    /**
     * Creates a form to delete a image entity.
     *
     * @param Image $image The image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Image $image)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_image_delete',
                ['id' => $image->getId()]
            ))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
