<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\CommentaireAnonyme;
use App\Entity\Etat;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin_", name="admin_")
 */
class AdminSeanceController extends AbstractController
{
    /**
     * @Route ("valider_seance_commentaire",name="valider")
     */
    public function valider()
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seances = $seanceRepo->findAll();

        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findAll();

        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentairesAnonymes = $commentaireAnonymeRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2)->getId();

        return $this->render('admin_seance/ValiderRDVEtCommentaire.html.twig',[
            'seances'=>$seances,
            'commentaires'=>$commentaires,
            'attente'=>$etatAttente,
            'commentairesAnonymes'=>$commentairesAnonymes
        ]);
    }


    /**
     * @Route ("/valider_seance/{id}",name="validerSeance")
     */
    public function validerSeance($id, EntityManagerInterface $em)
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatConfirme = $etatRepo->find(4);

        $seance->setNoEtatSeance($etatConfirme);
        $em->flush();

        return $this->redirectToRoute('admin_valider');
    }


    /**
     * @Route ("/refuser_seance/{id}",name="refuserSeance")
     */
    public function refuserSeance($id, EntityManagerInterface $em)
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatRefuse = $etatRepo->find(5);

        $seance->setNoEtatSeance($etatRefuse);
        $em->flush();

        return $this->redirectToRoute('admin_valider');
    }


    /**
     * @Route ("/archiver_seance/{id}",name="archiverSeance")
     */
    public function archiverSeance($id, EntityManagerInterface $em)
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatArchive = $etatRepo->find(6);

        $seance->setNoEtatSeance($etatArchive);
        $em->flush();

        return $this->redirectToRoute('admin_ajouterPhoto');
    }


    /**
     * @Route ("/desarchiver_seance/{id}",name="desarchiverSeance")
     */
    public function desarchiverSeance($id, EntityManagerInterface $em)
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatConfirme = $etatRepo->find(4);

        $seance->setNoEtatSeance($etatConfirme);
        $em->flush();

        return $this->redirectToRoute('admin_historiqueSeance');
    }


    /**
     * @Route ("/valider_commentaire/{id}_{seanceId}",name="validerCommentaire")
     */
    public function validerCommentaire($id,$seanceId, EntityManagerInterface $em)
    {
        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id);

        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($seanceId);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatPublie = $etatRepo->find(3);

        $seance->setNoEtatCommentaire($etatPublie);
        $commentaire->setNoEtat($etatPublie);
        $em->flush();

        return $this->redirectToRoute('admin_valider');
    }


    /**
     * @Route ("/refuser_commentaire/{id}_{seanceId}",name="refuserCommentaire")
     */
    public function refuserCommentaire($id, $seanceId, EntityManagerInterface $em)
    {
        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id);

        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($seanceId);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatRefuser = $etatRepo->find(5);

        $seance->setNoEtatCommentaire($etatRefuser);
        $commentaire->setNoEtat($etatRefuser);
        $em->flush();

        return $this->redirectToRoute('admin_valider');
    }


    /**
     * @Route ("/valider_commentaire_anonyme/{id}",name="validerCommentaireAnonyme")
     */
    public function validerCommentaireAnonyme($id, EntityManagerInterface $em)
    {
        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentaireAnonyme = $commentaireAnonymeRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatPublie = $etatRepo->find(3);

        $commentaireAnonyme->setNoEtat($etatPublie);
        $em->flush();

        return $this->redirectToRoute('admin_valider');
    }
}
