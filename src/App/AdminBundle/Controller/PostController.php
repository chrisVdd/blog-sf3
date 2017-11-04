<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Form\PostType;
use App\MainBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("post")
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="admin_post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Post[] $posts */
        $posts = $entityManager->getRepository('AppMainBundle:Post')->findAll();

        return $this->render('@AppAdmin/post/index.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="admin_post_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        /** @var Post $post */
        $post = new Post();

        /** @var Form $form */
        $form = $this->get('form.factory')->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Post bien enregistré');

            return $this->redirectToRoute('admin_post_show', ['id' => $post->getId()]);
        }

        return $this->render('@AppAdmin/post/new.html.twig',
            [
                'post' => $post,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="admin_post_show")
     * @Method("GET")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Post $post)
    {
        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('@AppAdmin/post/show.html.twig',
            [
                'post'        => $post,
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="admin_post_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Post $post)
    {
        /** @var Form $deleteForm */
        $deleteForm = $this->createDeleteForm($post);

        /** @var Form $editForm */
        $editForm = $this->createForm('App\MainBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
        }

        return $this->render('@AppAdmin/post/edit.html.twig',
            [
                'post'        => $post,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="admin_post_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Post $post)
    {
        /** @var Form $form */
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_post_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_post_delete', ['id' => $post->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
