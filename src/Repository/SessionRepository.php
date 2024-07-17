<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField(): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.sessionName LIKE :val')
    //            ->setParameter('val', '%Ord%')
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }


    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
      // Permet de récupérer tous les stagiaires non inscrits à une session
       public function getTraineesNotRegistered($id) {

        $em = $this->getEntityManager();
        $sub  = $this->createQueryBuilder('z');

        $qb = $sub;
        // sélectionner tous les stagiaires d'une session dont l'id est passée en paramètre
        $qb->select('t')
          ->from('App\Entity\Trainee', 't')
          ->leftJoin('t.sessions', 'se')
          ->andWhere('se.id = :id');


        $sub = $em->createQueryBuilder('w');
        // sélectionner tous les stagiaires qui ne SONT PAS (NOT IN) dans le résultat précédent
        // on obtient donc les stagiaires non inscrits pour une session définie
        $sub->select('st')
             ->from('App\Entity\Trainee', 'st')
             ->where($sub->expr()->notIn('st.id',  $qb->getDQL()))
             //requête paramétrée
             ->setParameter('id', $id);
             // trier la liste des stagiaires sur le nom de famille
            //  ->orderBy('st.nom');

        // renvoyer le résultat
        $query = $sub->getQuery();
        return $query->getResult();
       }

}

