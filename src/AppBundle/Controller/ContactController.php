<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package AppBundle\Controller
 * @Route("/{_locale}/")
 */
class ContactController extends Controller
{
    /**
     * @param $from
     * @param $message
     * @Route("/contact-email/{from}/{message}", methods={"POST"})
     */
    public function sendEmailAction($from, $message)
    {
        $message = (new \Swift_Message($from))
            ->setFrom('lkonieczny@zwdmalec.pl')
            ->setTo('lookasziebice@gmail.com')
            ->setBody(
                $message,
                'text/html'
            );
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('homepage');
    }
}
