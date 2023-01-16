<?php

namespace App\Controller;

use App\Entity\Reservation;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Repository\UserRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{

    #[Route('/payment{id}', name: 'payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


    #[Route('/checkout{id}', name: 'checkout')]
    public function checkout($id,$stripeSK,UserRepository $user,ReservationRepository $reservation): Response
    {
        $reservation=$reservation->find($id);
        $products_for_stripe[]=[
            'price_data'=>[
                'currency'=>'eur', 
                'unit_amount'=> $reservation->getTotal()."00",
                'product_data'=>[
                    'name' => $reservation->getNom(),
                    
                    
                ],
            ],
            'quantity' => 1,
        ];
        
        $nom=$reservation->getNom();
        $total=$reservation->getTotal();
       
        Stripe::setApiKey($stripeSK);
        
        $session = Session::create([
            
            'payment_method_types' => ['card'],
            'customer_email'=> $this->getUser()->getEmail(),
            'line_items'           => [$products_for_stripe],
        
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [ 'id'=>$reservation->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        
        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url/{id}', name: 'success_url')]
    public function successUrl(Request $request,ReservationRepository $reservationRepository,
    Reservation $reservation): Response
    {
      
        $reservation->setPaiement(true);
        $reservationRepository->save($reservation,true);
      
        return $this->render('payment/success.html.twig', [
            'reservation'=>$reservation
        ]);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}
