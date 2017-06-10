<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\Company;
use Sunshine\UIBundle\Controller\SpfController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Company controller.
 *
 * @Route("admin/org/company")
 */
class CompanyController extends SpfController
{
    /**
     * Lists all company entities.
     *
     * @Route("/", name="admin_org_company_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('SunshineOrganizationBundle:Company')->findAll();

        return $this->spfRender('SunshineOrganizationBundle:company:index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/new", name="admin_org_company_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm('Sunshine\OrganizationBundle\Form\CompanyType', $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('admin_org_company_show', array('id' => $company->getId()));
        }

        return $this->render('@SunshineOrganization/company/new.html.twig', array(
            'company' => $company,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="admin_org_company_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);

        return $this->render('@SunshineOrganization/company/show.html.twig', array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="admin_org_company_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_company_edit', array('id' => $company->getId()));
        }

        return $this->render('@SunshineOrganization/company/edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="admin_org_company_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('admin_org_company_index');
    }

    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_org_company_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
