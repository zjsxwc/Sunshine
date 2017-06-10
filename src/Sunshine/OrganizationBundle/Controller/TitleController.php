<?php

namespace Sunshine\OrganizationBundle\Controller;

use Sunshine\OrganizationBundle\Entity\Title;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     *
     * @Route("/", name="admin_org_title_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $titles = $em->getRepository('SunshineOrganizationBundle:Title')->findAll();

        return $this->render('SunshineOrganizationBundle:title:index.html.twig', array(
            'titles' => $titles,
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($title);
            $em->flush();

            return $this->redirectToRoute('admin_org_title_show', array('id' => $title->getId()));
        }

        return $this->render('@SunshineOrganization/title/new.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a title entity.
     *
     * @Route("/{id}", name="admin_org_title_show")
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
     * @Route("/{id}/edit", name="admin_org_title_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Title $title)
    {
        $deleteForm = $this->createDeleteForm($title);
        $editForm = $this->createForm('Sunshine\OrganizationBundle\Form\TitleType', $title);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_org_title_edit', array('id' => $title->getId()));
        }

        return $this->render('title/edit.html.twig', array(
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
}
