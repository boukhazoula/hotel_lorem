<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserResaController extends AbstractController
{
    #[Route('/user/resa', name: 'app_user_resa')]
    public function index(): Response
    {
        return $this->render('user_resa/index.html.twig', [
            'controller_name' => 'UserResaController',
        ]);
    }
}
