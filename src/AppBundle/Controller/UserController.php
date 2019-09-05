<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}