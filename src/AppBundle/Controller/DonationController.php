<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Donation;
use AppBundle\Entity\Institution;
use AppBundle\Form\DonationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DonationController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/form", name="add_donation", methods={"GET", "POST"})
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
     */
    public function addedDonation()
    {
        return $this->render('@App/form/form-confirmation.html.twig');
    }
}
