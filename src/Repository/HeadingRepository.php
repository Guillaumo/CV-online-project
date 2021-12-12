<?php

namespace App\Repository;

use App\Entity\Heading;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Heading|null find($id, $lockMode = null, $lockVersion = null)
 * @method Heading|null findOneBy(array $criteria, array $orderBy = null)
 * @method Heading[]    findAll()
 * @method Heading[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeadingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Heading::class);
    }

    // /**
    //  * @return Heading[] Returns an array of Heading objects
    //  */
    public function findByCvs($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere(':val MEMBER OF h.cvs')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Heading
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}