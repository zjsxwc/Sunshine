<?php

namespace Sunshine\OrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * Doctrine entity manager
     * @var $em
     */
    protected $em;

    /**
     * @Route("/admin/org/", name="admin_org_front")
     */
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $org = $this->em->getRepository("SunshineOrganizationBundle:Organization")->find(1);
        if ($org !== null) {
            return $this->forward('SunshineOrganizationBundle:Organization:show', ['organization' => $org]);
        }

        $response = $this->forward('SunshineOrganizationBundle:Organization:new');
        return $response;
    }
}
