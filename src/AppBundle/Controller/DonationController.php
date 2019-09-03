<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Donation;
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
        $donation = new Donation();
        $form = $this->createForm('AppBundle\Form\DonationType', $donation);
//        var_dump($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
//            var_dump($form);exit;
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('brands_show');
        }
//        var_dump($form);
        return $this->render('@App/form/form.html.twig', array(
            'donation' => $donation,
            'form' => $form->createView(),
        ));
    }
}
