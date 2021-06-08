<?php

namespace App\Repository;

use App\Entity\Commentaire;
use App\Entity\CommentaireAnonyme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function recupererAllComment()
    {
        $em = $this->getEntityManager();
        $dql = "SELECT  c.commentaire, r.date, u.nom, u.prenom 
                from App\Entity\Commentaire c
                join App\Entity\RendezVous r 
                join App\Entity\Utilisateur u
                where c.noSeance = r.id
                and u.id = c.noUtilisateur
                order by r.date desc";
        $query = $em->createQuery($dql);
        return $query->getResult();
    }

    /* récupère le commentaire et la date de la séance et le client
    SELECT commentaire, rendez_vous.date, utilisateur.nom, utilisateur.prenom from commentaire
    inner join rendez_vous on commentaire.no_seance_id
    INNER JOIN utilisateur on commentaire.no_utilisateur_id
    WHERE commentaire.no_seance_id = rendez_vous.id
    and utilisateur.id = commentaire.no_utilisateur_id
    order by rendez_vous.date desc
     */


    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
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
    public function findOneBySomeField($value): ?Commentaire
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
