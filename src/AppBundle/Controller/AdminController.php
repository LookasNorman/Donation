<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("admin")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/page", name="admin_page")
     */
    public function adminPage()
    {
        return $this->render('@App/admin/base.html.twig');
    }

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

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/promote/{id}", name="user_promote", methods={"GET"})
     */
    public function promoteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $user->addRole("ROLE_ADMIN");
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $id,
        ]);
    }

}
