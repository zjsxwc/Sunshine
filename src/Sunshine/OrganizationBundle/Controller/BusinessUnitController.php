<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\BusinessUnit;
use Sunshine\OrganizationBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * BusinessUnit controller.
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

        $defaultCompany = $em->getRepository('SunshineOrganizationBundle:Company')->findOneBy([], ['orderNumber'=>'ASC']);
        $company = $em->getRepository('SunshineOrganizationBundle:Company')->findAll();
        $businessUnits = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findBy(['company'=>$defaultCompany]);
        dump($businessUnits);
        return $this->render('@SunshineOrganization/businessunit/index.html.twig', array(
            'company' => $company,
            'defaultCompany' => $defaultCompany,
            'businessUnits' => $businessUnits
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
        $request->get('company');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($businessUnit);
            $em->flush();

            return $this->redirectToRoute('admin_org_bu_show', array('id' => $businessUnit->getId()));
        }

        return $this->render('@SunshineOrganization/businessunit/new.html.twig', array(
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

        return $this->render('@SunshineOrganization/businessunit/show.html.twig', array(
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

        return $this->render('@SunshineOrganization/businessunit/edit.html.twig', array(
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
     * 获取部门的树状 json
     *
     * @param Request $request
     *
     * @Route("/tree/{name}", name="admin_org_bu_tree_json")
     * @Method("GET")
     * @return Response
     */
    public function getBusinessTreeJson(Request $request)
    {
        $companyName = $request->get('name');
        $em = $this->getDoctrine()->getManager();
        $bu = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findByCompanyName($companyName);
        $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->setChildrenIndex('children');
        $trees = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->childrenHierarchy(
            null,
            false
        );

        $company = [['id'=>1, 'text'=>$companyName]];
        if (null  !== $trees) {
            $trees = array_map(function($tree) {
                return array(
                    'id' => $tree['id'],
                    'text' => $tree['name']
                );
            }, $trees);
            $company[0]['children'] = $trees;
        }

        return new JsonResponse($company);
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
