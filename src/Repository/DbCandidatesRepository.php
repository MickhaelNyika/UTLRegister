<?php

namespace App\Repository;

use App\Entity\DbCandidates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DbCandidates>
 */
class DbCandidatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DbCandidates::class);
    }

    //    /**
    //     * @return DbCandidates[] Returns an array of DbCandidates objects
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

    //    public function findOneBySomeField($value): ?DbCandidates
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findBySearch($search)
    {
        return $this->createQueryBuilder('m')
            //->join('m.status', 's')
            //->join('m.artist', 'a')
            ->where('m.name LIKE :sc')
            ->orWhere('m.fistName LIKE :sc')
            ->orWhere('m.lastName LIKE :sc')
            ->orWhere('m.code LIKE :sc')
            ->setParameter('sc', '%'. $search .'%')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
