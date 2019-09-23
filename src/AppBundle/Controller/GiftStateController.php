<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GiftState;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Giftstate controller.
 *
 * @Route("/{_locale}/giftstate")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class GiftStateController extends Controller
{
    /**
     * Lists all giftState entities.
     *
     * @Route("/", name="giftstate_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $giftStates = $em->getRepository('AppBundle:GiftState')->findAll();

        return $this->render('@App/giftstate/index.html.twig', array(
            'giftStates' => $giftStates,
        ));
    }

    /**
     * Creates a new giftState entity.
     *
     * @Route("/new", name="giftstate_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $giftState = new Giftstate();
        $form = $this->createForm('AppBundle\Form\GiftStateType', $giftState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($giftState);
            $em->flush();

            return $this->redirectToRoute('giftstate_show', array('id' => $giftState->getId()));
        }

        return $this->render('@App/giftstate/new.html.twig', array(
            'giftState' => $giftState,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a giftState entity.
     *
     * @Route("/{id}", name="giftstate_show", methods={"GET"})
     */
    public function showAction(GiftState $giftState)
    {
        $deleteForm = $this->createDeleteForm($giftState);

        return $this->render('@App/giftstate/show.html.twig', array(
            'giftState' => $giftState,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing giftState entity.
     *
     * @Route("/{id}/edit", name="giftstate_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, GiftState $giftState)
    {
        $deleteForm = $this->createDeleteForm($giftState);
        $editForm = $this->createForm('AppBundle\Form\GiftStateType', $giftState);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('giftstate_edit', array('id' => $giftState->getId()));
        }

        return $this->render('@App/giftstate/edit.html.twig', array(
            'giftState' => $giftState,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a giftState entity.
     *
     * @Route("/{id}", name="giftstate_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, GiftState $giftState)
    {
        $form = $this->createDeleteForm($giftState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($giftState);
            $em->flush();
        }

        return $this->redirectToRoute('giftstate_index');
    }

    /**
     * Creates a form to delete a giftState entity.
     *
     * @param GiftState $giftState The giftState entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GiftState $giftState)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('giftstate_delete', array('id' => $giftState->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
