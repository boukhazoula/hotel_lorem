<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;



#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chambre $chambre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $tarif_unit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_arrive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_depart = null;
    
    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(nullable: true)]
    private ?bool $paiement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_jour = null;

    
 

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTarifUnit(): ?float
    {
        return $this->tarif_unit;
    }

    public function setTarifUnit(float $tarif_unit): self
    {
        $this->tarif_unit = $tarif_unit;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->date_arrive;
    }

    public function setDateArrive(\DateTimeInterface $date_arrive): self
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

  

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function isPaiement(): ?bool
    {
        return $this->paiement;
    }

    public function setPaiement(bool $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getDateJour(): ?\DateTimeInterface
    {
        return $this->date_jour;
    }

    public function setDateJour(\DateTimeInterface $date_jour): self
    {
        $this->date_jour = $date_jour;

        return $this;
    }

  

   
     
    public function __toString(): string
    {
        return $this->getNom();   
    }

}
