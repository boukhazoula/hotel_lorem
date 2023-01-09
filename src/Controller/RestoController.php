<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestoController extends AbstractController
{
    #[Route('/resto', name: 'app_resto')]
    public function index(): Response
    {
        return $this->render('resto/index.html.twig', [
            'controller_name' => 'RestoController',
        ]);
    }
}
