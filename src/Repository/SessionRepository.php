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
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
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
       
       public function request() {

        $qb  = $this->createQueryBuilder();
        $sub = $qb;

        $sub = $qb->select('trainee.id')
          ->from('trainee', 'session_trainee');

        $linked = $qb->select('trainee.id')
             ->from('trainee')
             ->where($qb->expr()->notIn('rl.request_id',  $sub->getDQL()))
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

