<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sunshine\UIBundle\Controller\SpfController;

/**
 * Organization controller.
 *
 * @Route("admin/org/organization")
 */
class OrganizationController extends SpfController
{
    /**
     * Lists all organization entities.
     *
     * @Route("/list", name="admin_org_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organizations = $em->getRepository('SunshineOrganizationBundle:Organization')->findAll();

        return $this->render('@SunshineOrganization/organization/index.html.twig', array(
            'organizations' => $organizations,
        ));
    }

    /**
     * Creates a new organization entity.
     *
     * @Route("/new", name="admin_org_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $organization = new Organization();
        $form = $this->createForm('Sunshine\OrganizationBundle\Form\OrganizationType', $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organization);
            $em->flush();

            return $this->redirectToRoute('admin_org_show', array('id' => $organization->getId()));
        }

        return $this->render('@SunshineOrganization/organization/new.html.twig', array(
            'organization' => $organization,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a organization entity.
     *
     * @Route("/{id}", name="admin_org_show")
     * @Method("GET")
     */
    public function showAction(Organization $organization)
    {
        $deleteForm = $this->createDeleteForm($organization);

        return $this->render('@SunshineOrganization/organization/show.html.twig', array(
            'organization' => $organization,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing organization entity.
     *
     * @Route("/{id}/edit", name="admin_org_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Organization $organization)
    {
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\OrganizationType', $organization);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            //return $this->redirectToRoute('admin_org_edit', array('id' => $organization->getId()));
        }

        return $this->spfRender('@SunshineOrganization/organization/edit.html.twig', array(
            'organization' => $organization,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a organization entity.
     *
     * @Route("/{id}", name="admin_org_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Organization $organization)
    {
        $form = $this->createDeleteForm($organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organization);
            $em->flush();
        }

        return $this->redirectToRoute('admin_org_index');
    }

    /**
     * Creates a form to delete a organization entity.
     *
     * @param Organization $organization The organization entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organization $organization)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_org_delete', array('id' => $organization->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
