<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\Title;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Sunshine\UIBundle\Controller\SpfController;

/**
 * Title controller.
 *
 * @Route("admin/org/title")
 */
class TitleController extends SpfController
{
    /**
     * Lists all title entities.
     * continue 是判断是否连续新建的标识
     *
     * @Route("/", name="admin_org_title_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $continue = $request->get('continue');
        switch ($continue) {
            case('true'):
                $continue = true;
                break;
            case('false'):
                $continue = false;
                break;
        }

        $titles = $em->getRepository('SunshineOrganizationBundle:Title')->findAll();

        return $this->render('SunshineOrganizationBundle:title:index.html.twig', array(
            'titles' => $titles,
            'continue' => $continue
        ));
    }

    /**
     * Creates a new title entity.
     *
     * @Route("/new", name="admin_org_title_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $title = new Title();
        $form = $this->createForm('Sunshine\OrganizationBundle\Form\TitleType', $title);
        $continue = $request->get('continue');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($title);
            $em->flush();

            return $this->redirectToRoute('admin_org_title_index', ['continue' => $continue]);
        }

        return $this->render('@SunshineOrganization/title/new.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a title entity.
     *
     * @Route("/show/{id}", name="admin_org_title_show")
     * @Method("GET")
     */
    public function showAction(Title $title)
    {
        $deleteForm = $this->createDeleteForm($title);

        return $this->render('@SunshineOrganization/title/show.html.twig', array(
            'title' => $title,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing title entity.
     *
     * @Route("/{name}/edit", name="admin_org_title_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Title $title)
    {
        $deleteForm = $this->createDeleteForm($title);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\TitleType', $title);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_title_index');
        }

        return $this->render('@SunshineOrganization/title/edit.html.twig', array(
            'title' => $title,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a title entity.
     *
     * @Route("/{id}", name="admin_org_title_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Title $title)
    {
        $form = $this->createDeleteForm($title);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($title);
            $em->flush();
        }

        return $this->redirectToRoute('admin_org_title_index');
    }

    /**
     * Creates a form to delete a title entity.
     *
     * @param Title $title The title entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Title $title)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_org_title_delete', array('id' => $title->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/export", name="admin_org_title_export")
     */
    public function exportAction()
    {
        $em = $this->getDoctrine()->getManager();
        $titles = $em->getRepository('SunshineOrganizationBundle:Title')->findAll();

        $rows[] = '岗位类型, 岗位名称, 岗位代码, 排序号, 岗位描述';
        foreach ($titles as $title) {
            $data = [
                $title->getType(),
                $title->getName(),
                $title->getCode(),
                $title->getOrderNumber(),
                $title->getDescription()
            ];
            $rows[] = implode(',', $data);
        }

        $content = implode("\n", $rows);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('charset', 'utf-8');

        return $response;
    }

    /**
     * @Route("/export/template", name="admin_org_title_exportTemplate")
     * @return Response
     */
    public function exportTemplate()
    {
        $rows[] = '岗位类型, 岗位名称, 岗位代码, 排序号, 岗位描述';

        $content = implode("\n", $rows);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('charset', 'utf-8');

        return $response;
    }
}
