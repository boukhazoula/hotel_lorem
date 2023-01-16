<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

/**
    * @return Reservation[] Returns an array of Reservation objects
   */
  public function findChambreResa($arrive, $depart, $category): array
  {
      return $this->createQueryBuilder('r')
        ->select('chambre','r')
        ->join('r.chambre', 'chambre')
        ->andWhere('chambre.category in (:categorie)')
        ->andWhere('r.date_arrive < :depart')
        ->andWhere('r.date_depart > :arrive')
        ->setParameter('categorie', $category)
        ->setParameter('arrive', $arrive)
        ->setParameter('depart', $depart)
        ->orderBy('r.id', 'ASC')
          
          ->getQuery()
          ->getResult()
      ;
  }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
