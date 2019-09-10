<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Donation;
use AppBundle\Entity\Institution;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Donation controller.
 *
 * @Route("donation")
 */
class DonationController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/form", name="add_donation", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function addDonation(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $donation = new Donation();
        $form = $this->createForm('AppBundle\Form\DonationType', $donation);

        $institutions = $em->getRepository(Institution::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('added_donation');
        }

        return $this->render('@App/form/form.html.twig', array(
            'donation' => $donation,
            'categories' => $categories,
            'institutions' => $institutions,
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/formConfirmation", name="added_donation")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addedDonation()
    {
        return $this->render('@App/form/form-confirmation.html.twig');
    }

    /**
     * Lists all donation entities.
     *
     * @Route("/", name="donation_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('AppBundle:Donation')->findAll();

        return $this->render('@App/donation/index.html.twig', array(
            'donations' => $donations,
        ));
    }

    /**
     * Finds and displays a donation entity.
     *
     * @Route("/{id}", name="donation_show", methods={"GET"})
     */
    public function showAction(Donation $donation)
    {
        return $this->render('@App/donation/show.html.twig', array(
            'donation' => $donation,
        ));
    }

}
