<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\ServiceGrade;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Servicegrade controller.
 *
 * @Route("admin/org/servicegrade")
 */
class ServiceGradeController extends Controller
{
    /**
     * Lists all serviceGrade entities.
     *
     * @Route("/", name="admin_org_servicegrade_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $serviceGrades = $em->getRepository('SunshineOrganizationBundle:ServiceGrade')->findAll();

        return $this->render('@SunshineOrganization/servicegrade/index.html.twig', array(
            'serviceGrades' => $serviceGrades,
        ));
    }

    /**
     * Creates a new serviceGrade entity.
     *
     * @Route("/new", name="admin_org_servicegrade_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $serviceGrade = new Servicegrade();
        $form = $this->createForm('Sunshine\OrganizationBundle\Form\ServiceGradeType', $serviceGrade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serviceGrade);
            $em->flush();

            return $this->redirectToRoute('admin_org_servicegrade_index');
        }

        return $this->render('@SunshineOrganization/servicegrade/new.html.twig', array(
            'serviceGrade' => $serviceGrade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a serviceGrade entity.
     *
     * @Route("/{id}", name="admin_org_servicegrade_show")
     * @Method("GET")
     */
    public function showAction(ServiceGrade $serviceGrade)
    {
        $deleteForm = $this->createDeleteForm($serviceGrade);

        return $this->render('servicegrade/show.html.twig', array(
            'serviceGrade' => $serviceGrade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing serviceGrade entity.
     *
     * @Route("/{name}/edit", name="admin_org_servicegrade_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ServiceGrade $serviceGrade)
    {
        $deleteForm = $this->createDeleteForm($serviceGrade);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\ServiceGradeType', $serviceGrade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_servicegrade_index');
        }

        return $this->render('@SunshineOrganization/servicegrade/edit.html.twig', array(
            'serviceGrade' => $serviceGrade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a serviceGrade entity.
     *
     * @Route("/{id}", name="admin_org_servicegrade_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ServiceGrade $serviceGrade)
    {
        $form = $this->createDeleteForm($serviceGrade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($serviceGrade);
            $em->flush();
        }

        return $this->redirectToRoute('admin_org_servicegrade_index');
    }

    /**
     * Creates a form to delete a serviceGrade entity.
     *
     * @param ServiceGrade $serviceGrade The serviceGrade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ServiceGrade $serviceGrade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_org_servicegrade_delete', array('id' => $serviceGrade->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
