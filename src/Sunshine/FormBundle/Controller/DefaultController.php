<?php

namespace Sunshine\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package Sunshine\FormBundle\Controller
 *
 * @Route("admin/form")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('SunshineFormBundle:Default:index.html.twig');
    }

    /**
     * @Route("/new")
     */
    public function newAction()
    {
        return $this->render('SunshineFormBundle:Default:new.html.twig');
    }
}
