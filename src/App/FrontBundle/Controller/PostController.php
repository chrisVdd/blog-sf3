<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/10/17
 * Time: 14:17
 */

namespace App\FrontBundle\Controller;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    /**
     * Render a list of the last posts
     *
     * @param $limit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menuAction($limit)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $list = $entityManager
            ->getRepository('AppMainBundle:Post')
            ->findBy([], ['created' => 'DESC'], $limit, 0);

        return $this->render('AppFrontBundle:Core:last-post.html.twig',
            [
                'list' => $list
            ]
        );


    }
}