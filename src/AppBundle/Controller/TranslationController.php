<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TranslationController extends Controller
{
    /**
     * @return JsonResponse
     * @Route("/{_locale}/tran/{id}")
     */
    public function translateAction($id)
    {
        $translated = $this->get('translator')->transChoice('donation.form.bags', $id);
        return JsonResponse::create($translated);
    }
}
