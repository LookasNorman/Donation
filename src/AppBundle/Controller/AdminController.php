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

        return $this->render('@App/admin/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function showAction(User $user)
    {

        return $this->render('@App/admin/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('@App/admin/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
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

        return $this->redirectToRoute('admin_show', [
            'id' => $id,
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/demote/{id}", name="user_demote", methods={"GET"})
     */
    public function demoteUser($id)
    {
        $admin = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        //Blocking removal of yours rights
        if( $admin == $user) {
            return $this->redirectToRoute('admin_index');
        }
        $user->removeRole("ROLE_ADMIN");
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_show', [
            'id' => $id,
        ]);
    }
}
