<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\CommentaireAnonyme;
use App\Entity\Etat;
use App\Entity\Photo;
use App\Entity\PhotoPanorama;
use App\Entity\PhotoPrestation;
use App\Entity\Prestation;
use App\Entity\RendezVous;
use App\Entity\Renseignement;
use App\Entity\Utilisateur;
use App\Form\CommentaireAnonymeChoixAffichageType;
use App\Form\CommentaireChoixAffichageType;
use App\Form\CommentType;
use App\Form\PhotoPanoramaType;
use App\Form\PhotoPrestationType;
use App\Form\PhotoType;
use App\Form\PrestationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/admin_", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="menuAdmin")
     */
    public function menuAdmin(): Response
    {
        return $this->render('admin/MenuAdmin.html.twig');
    }


    /**
     * @Route ("/historique_seance",name="historiqueSeance")
     */
    public function historiqueSeance()
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seances = $seanceRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatArchive = $etatRepo->find(6)->getId();
        $etatConfirme = $etatRepo->find(4)->getId();

        return $this->render('admin/HistoriqueSeances.html.twig',[
                        'seances'=>$seances,
                        'etatArchive'=>$etatArchive,
                        'etatConfirme'=>$etatConfirme
        ]);
    }

    /**
     * @Route ("modifier_panorama",name="modifierPanorama")
     */
    public function modifierPanorama(EntityManagerInterface $em, Request $request)
    {
        $photo = new PhotoPanorama();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();

        $form = $this->createForm(PhotoPanoramaType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('admin_modifierPanorama',[
                'photos'=>$photos,
                'form'=>$form->createView()
            ]);
        }
        return $this->render('admin/modifierPanorama.html.twig',[
            'photos'=>$photos,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route ("/supprimer_photo_panorama{id}",name="supprimerPhotoPanorama")
     */
    public function supprimerPanorama($id, EntityManagerInterface $em)
    {
        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photo = $photoRepo->find($id);


        $em->remove($photo);
        $em->flush();

        return $this->redirectToRoute('admin_modifierPanorama');
    }


    /**
     * @Route ("/demandes_de_renseignements",name="gererRenseignement")
     */
    public function renseignement()
    {
        $renseignementRepo = $this->getDoctrine()->getRepository(Renseignement::class);
        $renseignements = $renseignementRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        return $this->render('admin/demandeRenseignement.html.twig',[
            'renseignements'=>$renseignements,
            'etatAttente'=>$etatAttente
        ]);
    }


    /**
     * @Route ("/archiver_renseignement/{id}",name="archiverRenseignement")
     */
    public function archiverRenseignement($id, EntityManagerInterface $em)
    {
        $renseignementRepo = $this->getDoctrine()->getRepository(Renseignement::class);
        $renseignementAArchiver = $renseignementRepo->find($id);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatArchive = $etatRepo->find(6);

        $renseignementAArchiver->setNoEtatRenseignement($etatArchive);

        $em->flush();

        return $this->redirectToRoute('admin_gererRenseignement');
    }


    /**
     * @Route ("/creer_utilisateur_seance_renseignement/{id}",name="creerUtilisateurSeanceRenseignement")
     */
    public function creerUtilisateurSeanceRenseignement($id, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatCommentaireNull = $etatRepo->find(1);
        $etatConfirme = $etatRepo->find(4);

        $renseignementRepo = $this->getDoctrine()->getRepository(Renseignement::class);
        $renseignement = $renseignementRepo->find($id);

        //Informations servant à la création de l'utilisateur
        $nomRenseignement = $renseignementRepo->find($id)->getNom();
        $prenomRenseignement = $renseignementRepo->find($id)->getPrenom();
        $mailRenseignement = $renseignementRepo->find($id)->getMail();
        $telRenseignement = $renseignementRepo->find($id)->getTelephone();

        //Informations servant à la création de la séance
        $renseignementDate = $renseignementRepo->find($id)->getDateSeance();
        $renseignementPrestation = $renseignementRepo->find($id)->getNoPrestation();
        $renseignementFormule = $renseignementRepo->find($id)->getNoFormule();

        $motPasseRenseignement = $nomRenseignement.$prenomRenseignement."2021";

        $renseignement->setNoEtatRenseignement($etatConfirme);

        //Permet de créer un compte utilisateur
        $user = new Utilisateur();

        $user->setNom($nomRenseignement);
        $user->setPrenom($prenomRenseignement);
        $user->setTelephone($telRenseignement);
        $user->setMail($mailRenseignement);
        $user->setAdmin(false);
        $user->setMotPasse($motPasseRenseignement);


        $hashed = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setMotPasse($hashed);

        $em->persist($user);
        $em->flush();
        //Fin création utilisateur

        //On crée une seance grâce aux infos du renseignement et le user créé
        $seance = new RendezVous();

        $seance->setDate($renseignementDate);
        $seance->setNoUtilisateur($user);
        $seance->setNoPrestation($renseignementPrestation);
        $seance->setNoEtatCommentaire($etatCommentaireNull);
        $seance->setNoEtatSeance($etatConfirme);
        $seance->setNoFormuleIntitule($renseignementFormule);

        $em->persist($seance);
        $em->flush();
        //Fin création séance

        return $this->redirectToRoute('admin_gererRenseignement');

    }


    /**
     * @Route ("/afficher_compte_utilisateur",name="afficherCompteUtilisateur")
     */
    public function afficherCompteUser()
    {
        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $utilisateurRepo->findAll();

        return $this->render('admin/supprimerCompteUser.html.twig',[
            'utilisateurs'=>$utilisateurs
        ]);
    }


    /**
     * @Route ("/supprimer_compte_utilisateur/{id}",name="supprimerCompteUtilisateur")
     */
    public function supprimerCompteUser($id, EntityManagerInterface $em)
    {
        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $utilisateurRepo->findAll();

        $utilisateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurASupprimer = $utilisateurRepo->find($id);

        $em->remove($utilisateurASupprimer);
        $em->flush();

        return $this->redirectToRoute('admin_afficherCompteUtilisateur',[
            'utilisateurs'=>$utilisateurs
        ]);
    }


    /**
     * @Route ("/liste_choix_commentaire",name="listeChoixCommentaire")
     */
    public function listeChoixCommentaire()
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations = $prestationRepo->findAll();

        return $this->render('admin/listeCommentaires.html.twig',[
            'prestations'=>$prestations
        ]);
    }


    /**
     * @Route ("/choix_affichage_commentaire/{id}",name="choixAffichageCommentaire")
     */
    public function choixCommentaire($id)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($id);

        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findAll();

        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentairesAnonymes = $commentaireAnonymeRepo->findAll();

        $form = $this->createForm(CommentaireChoixAffichageType::class);

        return $this->render('admin/choixAffichageCommentaire.html.twig',[
            'commentaires'=>$commentaires,
            'commentairesAnonymes'=>$commentairesAnonymes,
            'prestation'=>$prestation,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/retirer_affichage_commentaire/{id}/{prestationId}",name="retirerAffichageCommentaire")
     */
    public function retirerAffichageCommentaire($id, $prestationId, EntityManagerInterface $em)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($prestationId)->getId();

        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaireARetirer = $commentaireRepo->find($id);

        $retirerCommentaire = 0;

        $commentaireARetirer->setNumeroCommentaire($retirerCommentaire);
        $em->flush();

        return $this->redirectToRoute('admin_choixAffichageCommentaire',[
            'id'=>$prestation
        ]);
    }


    /**
     * @Route ("/choix_numero_commentaire/{id}/{prestationId}", name="choixNumeroCommentaire")
     */
    public function choixNumeroCommentaire($id, $prestationId, EntityManagerInterface $em, Request $request)
    {
        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id);
        $commentaires = $commentaireRepo->findAll();

        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentaireAnonyme = $commentaireAnonymeRepo->find($id);
        $commentairesAnonymes = $commentaireAnonymeRepo->findAll();

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($prestationId);


        $form = $this->createForm(CommentaireChoixAffichageType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute('admin_choixAffichageCommentaire',[
                'id'=>$prestationId
            ]);
        }

        return $this->render('admin/choixAffichageCommentaire.html.twig',[
            'commentaires'=>$commentaires,
            'commentairesAnonymes'=>$commentairesAnonymes,
            'prestation'=>$prestation,
            'form'=>$form->createView()
        ]);
    }

//Voir si vraiment utile pour 10 clients
    /**
     * @Route ("/choix_numero_commentaire_anonyme/{id}/{prestationId}", name="choixNumeroCommentaireAnonyme")
     */
    public function choixNumeroCommentaireAnonyme($id, $prestationId, EntityManagerInterface $em, Request $request)
    {
        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $commentaireRepo->find($id);
        $commentaires = $commentaireRepo->findAll();

        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentaireAnonyme = $commentaireAnonymeRepo->find($id);
        $commentairesAnonymes = $commentaireAnonymeRepo->findAll();

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($prestationId);


        $form = $this->createForm(CommentaireAnonymeChoixAffichageType::class, $commentaireAnonyme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute('admin_choixAffichageCommentaire',[
                'id'=>$prestationId
            ]);
        }

        return $this->render('admin/choixAffichageCommentaire.html.twig',[
            'commentaires'=>$commentaires,
            'commentairesAnonymes'=>$commentairesAnonymes,
            'prestation'=>$prestation,
            'form'=>$form->createView()
        ]);
    }
}
