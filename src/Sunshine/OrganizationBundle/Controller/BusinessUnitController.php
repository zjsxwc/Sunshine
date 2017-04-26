<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\BusinessUnit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Businessunit controller.
 *
 * @Route("admin/org/bu")
 */
class BusinessUnitController extends Controller
{
    /**
     * Lists all businessUnit entities.
     *
     * @Route("/", name="admin_org_bu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $businessUnits = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findAll();

        return $this->render('businessunit/index.html.twig', array(
            'businessUnits' => $businessUnits,
        ));
    }

    /**
     * Creates a new businessUnit entity.
     *
     * @Route("/new", name="admin_org_bu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $businessUnit = new Businessunit();
        $form = $this->createForm('Sunshine\OrganizationBundle\Form\BusinessUnitType', $businessUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($businessUnit);
            $em->flush();

            return $this->redirectToRoute('admin_org_bu_show', array('id' => $businessUnit->getId()));
        }

        return $this->render('businessunit/new.html.twig', array(
            'businessUnit' => $businessUnit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a businessUnit entity.
     *
     * @Route("/{id}", name="admin_org_bu_show")
     * @Method("GET")
     */
    public function showAction(BusinessUnit $businessUnit)
    {
        $deleteForm = $this->createDeleteForm($businessUnit);

        return $this->render('businessunit/show.html.twig', array(
            'businessUnit' => $businessUnit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing businessUnit entity.
     *
     * @Route("/{id}/edit", name="admin_org_bu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BusinessUnit $businessUnit)
    {
        $deleteForm = $this->createDeleteForm($businessUnit);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\BusinessUnitType', $businessUnit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_bu_edit', array('id' => $businessUnit->getId()));
        }

        return $this->render('businessunit/edit.html.twig', array(
            'businessUnit' => $businessUnit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a businessUnit entity.
     *
     * @Route("/{id}", name="admin_org_bu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BusinessUnit $businessUnit)
    {
        $form = $this->createDeleteForm($businessUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($businessUnit);
            $em->flush();
        }

        return $this->redirectToRoute('admin_org_bu_index');
    }

    /**
     * Creates a form to delete a businessUnit entity.
     *
     * @param BusinessUnit $businessUnit The businessUnit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BusinessUnit $businessUnit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_org_bu_delete', array('id' => $businessUnit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
