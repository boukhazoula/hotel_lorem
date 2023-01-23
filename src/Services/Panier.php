<?php
namespace App\Services;

use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier{
    private $session;
    private $reservationRepository;
    public function __construct(SessionInterface $sessionInterface,ReservationRepository $reservationRepository)
    {
        $this->session=$sessionInterface;
        $this->reservationRepository=$reservationRepository;
    }
    /**
     * récup le tableau de la session
     *
     * @return array
     */
    public function getPanier(){
        return $this->session->get('panier',[]);
    }
     /**
     * ajoute un produit au panier si existe sinon rajoute 1 a la quantité
     *
     * @param integer $id
     * @return void
     */
    public function addPanier($id)
    {
        $panier=$this->getPanier();
        if(!empty($panier[$id])){
            $panier[$id]=$panier[$id]+1;
        }else{
            $panier[$id]=1;
        }
        $this->session->set('panier',$panier);
    }

    /**
  * Undocumented function
  *
  * @return void
  */
  public function deletePanier(){
    $this->session->remove('panier');
  }
  /**
    * Undocumented function
    *
    * @param integer  $id
    * @return void
    */
    public function deleteReservationPanier($id){
        $panier=$this->getPanier();
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
    }
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */ 
    public function ddeleteQuantityReservationPanier($id){
        $panier=$this->getPanier();
        if (!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]=$panier[$id] -1;
            }else {
               unset($panier[$id]);
            }

        }
        $this->session->set('panier',$panier);
    }
    // public function getDetailPanier(){
    //     $panier=$this->getPanier();
    //     $panier_detail=[];
    //     foreach ($panier as $id => $quantity) {
    //         $reservation=$this->reservationRepository->find($id);
    //         if ($reservation) {
    //             $panier[]=[


    //             ]
    //         }
    //     }
    // }
}