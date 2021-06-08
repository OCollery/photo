<?php

namespace App\Repository;

use App\Entity\PhotoPrestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoPrestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoPrestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoPrestation[]    findAll()
 * @method PhotoPrestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoPrestation::class);
    }

    // /**
    //  * @return PhotoPrestation[] Returns an array of PhotoPrestation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoPrestation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
