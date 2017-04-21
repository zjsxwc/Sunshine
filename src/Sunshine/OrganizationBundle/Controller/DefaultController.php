<?php

namespace Sunshine\OrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/org")
     */
    public function indexAction()
    {
        return $this->render('SunshineOrganizationBundle:Default:organizationOrg.html.twig');
    }
}
