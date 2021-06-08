<?php

namespace App\Repository;

use App\Entity\FormuleIntitule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormuleIntitule|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormuleIntitule|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormuleIntitule[]    findAll()
 * @method FormuleIntitule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormuleIntituleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormuleIntitule::class);
    }

    // /**
    //  * @return FormuleIntitule[] Returns an array of FormuleIntitule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormuleIntitule
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
