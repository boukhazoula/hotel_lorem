<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestoController extends AbstractController
{
    #[Route('/resto', name: 'app_resto')]
    public function index(UserRepository $user,ReservationRepository $reservation): Response
    {
        
        
       
        return $this->render('resto/index.html.twig', [
            // 'reservations' => $reservation->findby($user),
           
        ]);
    }
}
