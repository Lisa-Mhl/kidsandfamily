<?php

namespace App\Repository;

use App\Entity\Contribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contribute[]    findAll()
 * @method Contribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contribute::class);
    }

    // /**
    //  * @return Contribute[] Returns an array of Contribute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contribute
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
