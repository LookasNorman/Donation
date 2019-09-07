<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loggedUserMenuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();

        $loggedUser = $em->getRepository(User::class)->find($user);

        return $this->render('@App/menu/logged-user.html.twig', [
            'loggedUser' => $loggedUser,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin", name="admin_page")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function adminPageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user->getId();

        $loggedUser = $em->getRepository(User::class)->find($user);

        return $this->render('@App/user/admin-page.html.twig', [
            'loggedUser' => $loggedUser,
        ]);
    }
}
