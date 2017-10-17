<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 17/10/17
 * Time: 17:05
 */

namespace App\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 * @package App\AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        return $this
            ->container
            ->get('templating')
            ->renderResponse('AppAdminBundle:Security:login.html.twig', $data);
    }
}