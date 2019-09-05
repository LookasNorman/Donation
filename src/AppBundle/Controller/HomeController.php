<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Donation;
use AppBundle\Entity\Institution;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $institutions = $em->getRepository(Institution::class)->findAll();

        return $this->render('@App/home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'institutions' => $institutions,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function quantityBagsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $quantityBags = $em->getRepository(Donation::class)->sumQuantityBags();

        return $this->render('@App/home/quantity-bags.html.twig', [
            'quantityBags' => $quantityBags,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function donateInstitutionsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $donateInstitutions = count($em->getRepository(Donation::class)->institution());

        return $this->render('@App/home/donate-institutions.html.twig', [
            'donateInstitutions' => $donateInstitutions,
        ]);
    }
}
