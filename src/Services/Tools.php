<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Reservation;
use App\Repository\ChambreRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class Tools
{
    private $security;
    private $chambreRepository;
    private $reservationRepository;

    public function __construct(Security $security, ChambreRepository $chambreRepository, ReservationRepository $reservationRepository){
        $this->security = $security;
        $this->chambreRepository = $chambreRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getUser(): ?User
    {
        return $this->security->getUser();
    }

    public function getTotalreservation(Chambre $chambre, DateTime $date_depart, DateTime $date_arrive): ?float
    {
        $nb_jour = $date_depart->diff($date_arrive)->format('%a');
        $tarif = $chambre->getTarif();
        $total = $nb_jour * $tarif;
        return $total;
    }

    public function testDonnesUser(){
        $user = $this->getUser();
        $nom_user = $user->getNom();
        $user_prenom = $user->getPrenom();
        $tel = $user->getTel();

            if ( !$nom_user || !$user_prenom || !$tel) {
                return true;
            }else{
                return false;
            }
    }

    /**
     * Undocumented function
     *
     * @param [type] $date_depart
     * @param [type] $date_arrive
     * @param [type] $date_jour
     * @param [type] $id
     * @param [type] $nom
     * @param [type] $tarifUnit
     * @return Reservation
     */
    public function newReservation($date_depart,$date_arrive,$id,$nom,$tarifUnit) :Reservation{
        $date_jour = new DateTime('', new DateTimeZone('Europe/Paris'));
            $reservation = new Reservation();
    
            $reservation -> setDateArrive($date_arrive);
    
            $reservation -> setDateDepart($date_depart);
    
            $reservation -> setDateJour($date_jour);
            
            $reservation -> setChambre($this->chambreRepository->find($id));

            $reservation -> setNom($nom);
            
            $reservation -> setTarifUnit($tarifUnit);

            $reservation -> setTotal($this->getTotalreservation( $this->chambreRepository->find($id) , $date_depart, $date_arrive));
    
            $reservation -> setUser($this->getUser());      
    
            return($reservation);
        }
}