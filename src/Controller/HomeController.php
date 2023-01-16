<?php

namespace App\Controller;

use DateTime;
use App\Services\Tools;
use App\Form\RechercheChambreType;
use App\Services\RechercheChambre;
use App\Services\SelectChambreDispo;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, SelectChambreDispo $selectChambreDispo): Response
    {
        $rechercheChambre = new RechercheChambre();
        $form = $this->createForm(RechercheChambreType::class, $rechercheChambre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $dateDepart = $form -> get('date_depart') -> getData();
            $dateArrive = $form -> get('date_arrive') -> getData();
            $category = $form ->get('category') -> getData();
            $interval = $dateDepart->diff($dateArrive);
           
            $tableauChambre = $selectChambreDispo->getChambreDispo($dateArrive,$dateDepart, $category);

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'chambresDispo' => $tableauChambre,
            'nb_jour' => $interval->format('%a'),
            'date_depart' => $dateDepart,
            'date_arrive' => $dateArrive
        ]);
    }

    return $this->render('home/index.html.twig',[
        'form' => $form->createView(),
    ]);
    }

    #[Route('/new_reservation/{id}/{date_depart}/{date_arrive}/{total}/{nom}/{tarifUnit}', name : 'app_user_reservation')]
    public function newReservation(DateTime $date_depart, DateTime $date_arrive, $id, ReservationRepository $reservationRepository, Tools $tools, $nom, $tarifUnit): Response{
        $user = $this->getUser();
      
        if($user){
            if($tools->testDonnesUser()){
                return $this->redirectToRoute('app_user');
            }
        }else{
            return $this->redirect('app_login');
        }
        
        $reservation = $tools->newReservation($date_depart, $date_arrive, $id,$nom,$tarifUnit);

        $reservationRepository->save($reservation, true);
        
        $id_resa = $reservation ->getId();


        return $this->redirectToRoute('checkout',['id' => $id_resa]);
    }
}
