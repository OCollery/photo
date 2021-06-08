<?php

namespace App\Repository;

use App\Entity\CommentaireAnonyme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireAnonyme|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireAnonyme|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireAnonyme[]    findAll()
 * @method CommentaireAnonyme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireAnonymeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireAnonyme::class);
    }

    // /**
    //  * @return CommentaireAnonyme[] Returns an array of CommentaireAnonyme objects
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
    public function findOneBySomeField($value): ?CommentaireAnonyme
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
