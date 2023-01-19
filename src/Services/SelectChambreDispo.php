<?php
namespace App\Services;

use App\Repository\ChambreRepository;
use App\Repository\ReservationRepository;

class SelectChambreDispo{

    private $chambreRepository;
    private $reservationRepository;

    public function __construct(ChambreRepository $chambreRepository, ReservationRepository $reservationRepository)
    {
        $this->chambreRepository = $chambreRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getChambreResa( $date_arrive,$date_depart, $category)
    {
        
        $tab_id = [];
        $liste_chambre_resa = $this->reservationRepository-> findChambreResa( $date_arrive,$date_depart, $category);
       
        foreach( $liste_chambre_resa as $resa_chambre){
            $tab_id[]= $resa_chambre->getChambre()->getId();
        }

        return $tab_id;
    }

    public function getChambreDispo($date_depart, $date_arrive, $category)
    {
        $tab_id_chambre_Ndispo = $this->getChambreResa($date_depart, $date_arrive, $category);
        $tab_chambre = $this->chambreRepository ->findby(["category"=>$category]);
        $tab_chambre_dispo = [];
        foreach($tab_chambre as $chambre){
            if(!in_array($chambre->getId(), $tab_id_chambre_Ndispo)){
                $tab_chambre_dispo[] = $chambre;
            }
        }
        return $tab_chambre_dispo;
    }

}