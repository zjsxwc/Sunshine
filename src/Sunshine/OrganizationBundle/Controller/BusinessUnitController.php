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
        $defaultCompany ? $defaultCompany : $defaultCompany = 'nothing';
        $company = $em->getRepository('SunshineOrganizationBundle:Company')->findAll();
        $businessUnits = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findBy(['company'=>$defaultCompany]);
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

            return $this->redirectToRoute('admin_org_bu_index');
        }

        return $this->render('@SunshineOrganization/businessunit/new.html.twig', array(
            'businessUnit' => $businessUnit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing businessUnit entity.
     *
     * @Route("/{name}/edit", name="admin_org_bu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BusinessUnit $businessUnit)
    {
        $deleteForm = $this->createDeleteForm($businessUnit);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\BusinessUnitType', $businessUnit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_bu_index');
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
     * @Route("/delete/", name="admin_org_bu_delete")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request)
    {
        $companyName = $request->get('name');
        $em = $this->getDoctrine()->getManager();
        $bu = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findOneBy(["name" => $companyName]);

        if (!$bu) {
            $resultArr = array('deleted'=>0);
            return new JsonResponse($resultArr);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($bu);
        $em->flush();

        $resultArr = array('deleted'=>1);
        return new JsonResponse($resultArr);
    }

    /**
     * 检查是否满足删除此部门的条件
     *
     * @Route("/check/", name="admin_org_bu_check")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function checkAction(Request $request)
    {
        $companyName = $request->get('name');
        $em = $this->getDoctrine()->getManager();
        $bu = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->findOneBy(["name" => $companyName]);
        $hasChildren = $em->getRepository('SunshineOrganizationBundle:BusinessUnit')->childCount($bu);
        $hasUser = $em->getRepository('SunshineOrganizationBundle:User')->findOneBy(['businessUnit' => $bu]);

        /**
         * 如果此部门有子部门或此部门下有用户就不能删除这个部门。
         * approved 为假不能删除，为真可以删除
         */
        $resultArr = array('approved'=>0);

        if (!$hasChildren && !$hasUser) {
            $resultArr = array('approved'=>1);
        }

        return new JsonResponse($resultArr);
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
                    'text' => $tree['name'],
                    'children' => $tree['children']
                );
            }, $trees);

            $company[0]['children'] = $trees;
        }

        $json = json_encode($company);
        /**
         * That's really dirty implementation T_T
         * I must change the output array of childrenHierarchy to fit for the Tree UI library (EasyUI),
         * The UI library use text for the tree node label, but I did not find a way to define the output of
         * childrenHierarchy method to specific array key name. And also I can't change the array key after
         * the output, I try array_map, but it's not work for multidimensional array, and array_walk_recursive
         * can change the value of the specific key which is "name", but it can't change the key itself :(
         *
         * If you got better solution, just tell me, thank you.
         */
        $jsonResult  = str_replace('name', 'text', $json);
        return new Response($jsonResult);
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
            ->setAction($this->generateUrl('admin_org_bu_delete', array('name' => $businessUnit->getName())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
