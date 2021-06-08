<?php

namespace App\Repository;

use App\Entity\PhotoPanorama;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoPanorama|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoPanorama|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoPanorama[]    findAll()
 * @method PhotoPanorama[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoPanoramaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoPanorama::class);
    }

    // /**
    //  * @return PhotoPanorama[] Returns an array of PhotoPanorama objects
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
    public function findOneBySomeField($value): ?PhotoPanorama
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
