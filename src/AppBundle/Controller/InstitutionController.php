<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Institution;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Institution controller.
 *
 * @Route("/{_locale}/institution")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class InstitutionController extends Controller
{
    /**
     * Lists all institution entities.
     *
     * @Route("/", name="institution_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $institutions = $em->getRepository('AppBundle:Institution')->findAll();

        return $this->render('@App/institution/index.html.twig', array(
            'institutions' => $institutions,
        ));
    }

    /**
     * Creates a new institution entity.
     *
     * @Route("/new", name="institution_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $institution = new Institution();
        $form = $this->createForm('AppBundle\Form\InstitutionType', $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($institution);
            $em->flush();

            return $this->redirectToRoute('institution_show', array('id' => $institution->getId()));
        }

        return $this->render('@App/institution/new.html.twig', array(
            'institution' => $institution,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a institution entity.
     *
     * @Route("/{id}", name="institution_show", methods={"GET"})
     */
    public function showAction(Institution $institution)
    {
        $deleteForm = $this->createDeleteForm($institution);

        return $this->render('@App/institution/show.html.twig', array(
            'institution' => $institution,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing institution entity.
     *
     * @Route("/{id}/edit", name="institution_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Institution $institution)
    {
        $deleteForm = $this->createDeleteForm($institution);
        $editForm = $this->createForm('AppBundle\Form\InstitutionType', $institution);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('institution_edit', array('id' => $institution->getId()));
        }

        return $this->render('@App/institution/edit.html.twig', array(
            'institution' => $institution,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a institution entity.
     *
     * @Route("/{id}", name="institution_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Institution $institution)
    {
        $form = $this->createDeleteForm($institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($institution);
            $em->flush();
        }

        return $this->redirectToRoute('institution_index');
    }

    /**
     * Creates a form to delete a institution entity.
     *
     * @param Institution $institution The institution entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Institution $institution)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('institution_delete', array('id' => $institution->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
