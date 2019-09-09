<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->showAllAdmin();

        return $this->render('@App/user/index.html.twig', array(
            'users' => $users,
        ));
    }

}
