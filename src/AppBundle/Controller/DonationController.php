<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Donation;
use AppBundle\Entity\GiftState;
use AppBundle\Entity\Institution;
use AppBundle\Form\DonationStateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swift_SmtpTransport;

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
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $giftState = $em->getRepository(GiftState::class)->findOneBy(['state' => 'Złożone']);

        $donation = new Donation();
        $donation->setState($giftState);
        $donation->setUser($user);
        $form = $this->createForm('AppBundle\Form\DonationType', $donation);

        $institutions = $em->getRepository(Institution::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('added_donation', [
                'id' => $donation->getId()
            ]);
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
    public function addedDonation(Request $request)
    {
        $id = $request->query->get('id');
        $donation = $this->getDoctrine()
            ->getManager()
            ->getRepository(Donation::class)
            ->find($id);
        $this->sendEmailAction($donation);
        return $this->render('@App/form/form-confirmation.html.twig');
    }

    /**
     * Lists all donation entities.
     *
     * @Route("/", name="donation_index", methods={"GET"})
     */
    public function indexAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('AppBundle:Donation')->findBy([
            'user' => $user
        ], [
            'state' => 'asc',
            'pickUpDate' => 'desc',
            'pickUpTime' => 'desc',
            'createdDate' => 'desc',
            'createdTime' => 'desc'
        ]);

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

    /**
     * @param Request $request
     * @param Donation $donation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}", name="donation_state", methods={"GET", "POST"})
     */
    public function changeStateAction(Request $request, Donation $donation)
    {
        $editForm = $this->createForm('AppBundle\Form\DonationStateType', $donation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $date = new \DateTime();
            $donation->setPickUpDate($date);
            $donation->setPickUpTime($date);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_show', array('id' => $donation->getId()));
        }

        return $this->render('@App/donation/changeState.html.twig', array(
            'donation' => $donation,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function sendEmailAction($donation)
    {
        $message = (new \Swift_Message('Dziękujemy za złożenie darowizny'))
            ->setFrom('lkonieczny@zwdmalec.pl')
            ->setTo($donation->getUser()->getEmail())
            ->setBody(
                $this->renderView('@App/Emails/donation.html.twig', [
                    'donation' => $donation
                ]),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

//        return $this->render(...);
    }
}
