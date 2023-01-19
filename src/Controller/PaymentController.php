<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Reservation;
use Stripe\Checkout\Session;
use App\Repository\UserRepository;
use App\Repository\ReservationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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
        return $this->redirectToRoute('emailConfirmation', []);
        return $this->render('payment/success.html.twig', [
            'reservation'=>$reservation
        ]);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
    #[Route('/stripe/emailConfirmation', name: 'emailConfirmation')]
    public function emailConfirmation(ReservationRepository $reservation,MailerInterface $mailer,): Response
    {
        // Récuperation de l'adresse de livraion de l'utilisateur
        $i = $reservation->findOneBy(['user' => $this->getUser()], ['id' => 'DESC'],['paiement' => 'true']);
       
     

        // Récupération du panier complet et du total
        
      
        $total =$i->getTotal();
       
        // Récupération des informations utilisateur
        $user = $this->getUser();
       
        $mail= $user->getUserIdentifier();
        
        // Création et envoie du mail de confirmation de commande
        $email = (new TemplatedEmail())
        ->from('eatstorytest@gmail.com')
        ->to($mail)
        ->subject('Confirmation de commande')
        ->htmlTemplate('payment/emailConfirmation.html.twig');
        
        
        $email->context([
            'nom' => $user->getNom(),
           
            'prenom' => $user->getPrenom(),
            'from' => '	eatstorytest@gmail.com',
           
            'liens' => 'http://127.0.0.1:8001/profil',
            'objectif' => 'Confirmation de commande',
            'items'=>$i,
            'total'=>$total,
            
        ]);

        $mailer->send($email);
      
        // Suppression du panier
        
        $this->addFlash('success', "Merci pour votre commande, Votre plat vous sera bientot livré, vous pouvez suivre l'état de votre commande dans votre espace membre");
        return $this->redirectToRoute('app_home', []);

        return $this->render('payment/emailConfirmation.html.twig', [
            'items'=>$reservation,
        ]);
    }
}
