<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/10/17
 * Time: 13:48
 */

namespace App\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CoreController
 * @package App\FrontBundle\Controller
 */
class CoreController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppFrontBundle:Core:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsAction()
    {
        return $this->render('AppFrontBundle:Core:news.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidatesAction()
    {
        return $this->render('AppFrontBundle:Core:candidates.html.twig');
    }

}