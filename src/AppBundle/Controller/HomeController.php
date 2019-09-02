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
        $quantityBags = $em->getRepository(Donation::class)->sumQuantityBags();
        $donateInstitutions = $em->getRepository(Donation::class)->institution();

        return $this->render('@App/home/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'institutions' => $institutions,
            'quantityBags' => $quantityBags,
            'donateInstitutions' => $donateInstitutions,
        ]);
    }
}
