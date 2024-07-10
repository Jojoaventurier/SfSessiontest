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
    //   récupérer les stagiaires non inscrit demandera en id  l'id de la session
    //   on va selectionner tous les stagiaires d'une session dont l'id est passée en parametres
    //   on selectionne tous les stagiaires qui ne sont pas dans le résultat précédent
      
       public function findTraineesBySession($session) {

        $qb  = $this->createQueryBuilder('s');
        $sub = $qb;

        $sub = $qb->select('trainee.id')
          ->from('session_trainee')
          ->andWhere('s.id = :val')
          ->setParameter('val', $session);


        $linked = $qb->select('trainee.id')
             ->from('trainee')
             ->where($qb->expr()->notIn('session_trainee',  $sub->getDQL()))
             ->getQuery()
             ->getResult();
       }

    //    public function requestNull() {
    //     $q = Doctrine_query::create()
    //          ->select('trainee.firstName')
    //          ->from('trainee')
    //          ->where('trainee.id NOT IN (
    //                             SELECT trainee.id
    //                             FROM
    //          )');
    //         return $q->getSqlquery();
    //    }


}

