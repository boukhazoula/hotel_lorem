<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Plan;
use App\Entity\User;
use App\Entity\Invoice;
use App\Entity\Reservation;
use App\Entity\Subscription;
use Psr\Log\LoggerInterface;
use Stripe\Invoice as StripeInvoice;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebhookController extends AbstractController
{
    #[Route('/webhook/stripe', name: 'app_webhook_stripe')]
    public function index($stripe_pk,LoggerInterface $logger, ManagerRegistry $doctrine,$stripeSK, $stripe_webhook_secret): Response
    {
        \Stripe\Stripe::setApiKey($stripeSK);
		
$endpoint = \Stripe\WebhookEndpoint::create([
  'url' => 'https://example.com/my/webhook/endpoint',
  'enabled_events' => [
    'charge.failed',
    'charge.succeeded',
  ],
]);
		// $event = null;


		// // // If you are testing your webhook locally with the Stripe CLI you
		// // // can find the endpoint's secret by running `stripe listen`
		// // // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
		//  $endpoint_secret = ( $stripe_webhook_secret);
		
		//  $payload = @file_get_contents('php://input');

		// // $sig_header = $_SERVER($stripe_pk);
		// // dd($sig_header);
		//  $event = null;
		
		// try {
		// 	$event = \Stripe\Webhook::constructEvent(
		// 		$payload, $sig_header, $endpoint_secret
		// 	);
		// } catch(\UnexpectedValueException $e) {
		// 	// Invalid payload
		// 	http_response_code(400);
		// 	exit();
		// } catch(\Stripe\Exception\SignatureVerificationException $e) {
		// 	// Invalid signature
		// 	http_response_code(400);
		// 	exit();
		// }
		
		// // Handle the event
		// switch ($event->type) {
		// 	case 'payment_intent.succeeded':
		// 		$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
		// 		handlePaymentIntentSucceeded($paymentIntent);
		// 		break;
		// 	case 'payment_method.attached':
		// 		$paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
		// 		handlePaymentMethodAttached($paymentMethod);
		// 		break;
		// 	// ... handle other event types
		// 	default:
		// 		echo 'Received unknown event type ' . $event->type;
		// }
		
		Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email'=> $this->getUser()->getEmail(),
            'line_items'           => ["ff"],
        
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [ ], UrlGeneratorInterface::ABSOLUTE_URL),
            
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }
    
}
