<?php

namespace Sunshine\OrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sunshine\UIBundle\Controller\SpfController;

class DefaultController extends SpfController
{
    /**
     * Doctrine entity manager
     * @var $em
     */
    protected $em;

    /**
     * @Route("/admin/org/organization", name="admin_org_front")
     */
    public function indexAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $org = $this->em->getRepository("SunshineOrganizationBundle:Organization")->find(1);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\OrganizationType', $org);
        $editForm->handleRequest($request);

        if (null !== $org) {
            return $this->spfRender('SunshineOrganizationBundle:organization:edit.html.twig', array(
                'organization' => $org,
                'edit_form' => $editForm->createView()
            ));
        }

        $response = $this->forward('SunshineOrganizationBundle:Organization:new');
        return $response;
    }
}
