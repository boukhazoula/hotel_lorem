<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionslégalesRGPDController extends AbstractController
{
    #[Route('/mentionsl/gales/r/g/p/d', name: 'app_mentionsl_gales_r_g_p_d')]
    public function index(): Response
    {
        return $this->render('mentionslégales_rgpd/index.html.twig', [
            'controller_name' => 'MentionslégalesRGPDController',
        ]);
    }
}
