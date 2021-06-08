<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Etat;
use App\Entity\Photo;
use App\Entity\Prestation;
use App\Entity\RendezVous;
use App\Entity\Utilisateur;

use App\Form\CommentType;
use App\Form\RDVType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function Sodium\add;

class UserController extends AbstractController
{

    /**
     * @Route ("/creer_compte",name="createUser")
     */
    public function createUser(EntityManagerInterface $em,Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Utilisateur();

        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations= $prestationRepo->findAll();

        $user->setAdmin(false);


        if ($form->isSubmitted() && $form->isValid())
        {
            $hashed = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setMotPasse($hashed);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/createUser.html.twig',['prestations'=>$prestations,
                                                                'createForm'=>$form->createView()
        ]);
    }

    /**
     * @Route ("/supprimer_compte",name="supprimerCompte")
     */
    public function deleteUser(UserInterface $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('home');
    }




    /**
     * @Route ("/profile/prendre_rendez-vous",name="priseRDV")
     */
    public function rendezVous(EntityManagerInterface $em, Request $request, UserInterface $user)
    {
        $rendezVous = new RendezVous();
        $rendezVous->setNoUtilisateur($user);

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);
        $rendezVous->setNoEtatSeance($etatAttente);

        $etatNull = $etatRepo->find(1);
        $rendezVous->setNoEtatCommentaire($etatNull);

        $form = $this->createForm(RDVType::class,$rendezVous);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
        //DATE DU JOUR PASSE EN BOOLEAN FALSE EN TIMESTAMP???
            /*$dateRDV = $form['date']->getData();
            $dateRDVString = $dateRDV->format('d/m/Y');
            $dateRDVSeconde = strtotime($dateRDVString);

            $dateDuJour = date('d/m/Y');
            $dateDuJourSeconde = strtotime($dateDuJour);

            var_dump($dateRDVSeconde);
            var_dump($dateDuJourSeconde);

            if ($dateRDVSeconde < $dateDuJourSeconde) {
                $this->addFlash('error', 'Désolé mais je ne peux pas revenir dans la passé');
                return $this->redirectToRoute('priseRDV');
            }else{}*/

            $em->persist($rendezVous);
            $em->flush();

            $this->addFlash('success', 'Votre demande de rendez-vous a bien été enregistré');
            return $this->redirectToRoute('menuUser');


        }




        return $this->render('user/priseRDV.html.twig',[
                                'rendezVousForm'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/profile/mon_compte",name="monCompte")
     */
    public function monCompte(Request $request,
                              UserInterface $user,
                              EntityManagerInterface $em)
    {
        return $this->render('user/monCompte.html.twig',['user'=>$user]);
    }


    /**
     * @Route ("/profile/modifier_profil",name="edit")
     */
    public function editProfil(EntityManagerInterface $em, Request $request,
                               UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $pseudo = $user->getUsername();
        $utilisateurRepo = $em->getRepository(Utilisateur::class);
        $utilisateur = $utilisateurRepo->findOneBy(['mail'=>$pseudo]);

        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hashed = $passwordEncoder->encodePassword($user, $user->getMotPasse());
            $user->setMotPasse($hashed);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié');
            return $this->redirectToRoute('menuUser');
        }

        return $this->render('user/modifierProfil.html.twig',[
                            'editForm'=>$form->createView(),
                            'utilisateur'=>$utilisateur
        ]);
    }


    /**
     * @Route ("/profile_mes_seances",name="mesSeances")
     */
    public function seances(UserInterface $user)
    {
        $rendezVousRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVousAll = $rendezVousRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatConfirme = $etatRepo->find(4)->getId();
        $etatAttente = $etatRepo->find(2)->getId();

        $userId = $user->getId();

        return $this->render('user/mesSeances.html.twig',['seance'=>$rendezVousAll,
                                                    'user'=>$userId,
                                                    'etatConfirme'=>$etatConfirme,
                                                    'etatAttente'=>$etatAttente
        ]);
    }

    /**
     * @Route ("/mes_photos",name="mesPhotos")
     */
    public function listeSeancePhoto()
    {
        $rendezVousRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seances = $rendezVousRepo->findAll();

        return $this->render('user/photoSeance.html.twig',[
            'seances'=>$seances
        ]);
    }
    /**
     * @Route ("/mes_photos_{id}", name="mesPhotosSeance")
     */
    public function photos($id, UserInterface $user)
    {
        $rendezVousRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVous = $rendezVousRepo->find($id);

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photoAll = $photoRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);
        $etatChoisi = $etatRepo->find(7);
        $etatTelechargeable = $etatRepo->find(8);

        $utilsateurRepo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurAll = $utilsateurRepo->findAll();

        return $this->render('user/mesPhotos.html.twig',[
                                'utilisateurs'=>$utilisateurAll,
                                'user'=>$user,
                                'photos'=>$photoAll,
                                'seance'=>$rendezVous,
                                'etatAttente'=>$etatAttente,
                                'etatChoisi'=>$etatChoisi,
                                'etatTelechargeable'=>$etatTelechargeable
        ]);
    }

    /**
     * @Route ("/choisir_photo/{id}/{seanceId}", name="photoChoisi")
     */
    public function photoChoisi($id, $seanceId, EntityManagerInterface $em)
    {
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photoChoisi = $photoRepo->find($id);

        $rendezVousRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVous = $rendezVousRepo->find($seanceId)->getId();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatChoisi = $etatRepo->find(7);

        $photoChoisi->setNoEtat($etatChoisi);
        $em->flush();

        return $this->redirectToRoute('mesPhotosSeance',[
            'id'=>$rendezVous
        ]);

    }


    /**
     * @Route ("/retirer_Photo/{id}/{seanceId}", name="photoRetire")
     */
    public function photoRetirer($id, $seanceId, EntityManagerInterface $em)
    {
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photoChoisi = $photoRepo->find($id);

        $rendezVousRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVous = $rendezVousRepo->find($seanceId)->getId();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $photoChoisi->setNoEtat($etatAttente);
        $em->flush();

        return $this->redirectToRoute('mesPhotosSeance',[
            'id'=>$rendezVous
        ]);
    }


    /**
     * @Route ("/profile/commentaire",name="commentaire")
     */
    public function commentaire(UserInterface $user, Request $request, EntityManagerInterface $em)
    {
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatNull = $etatRepo->find(1);
        $etatConfirme = $etatRepo->find(4)->getId();

        $commentaire = new Commentaire();
        $commentaire->setNoUtilisateur($user);

        $userId = $user->getId();

        $rendezVousrepo= $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVousAll=$rendezVousrepo->findAll();

        $form = $this->createForm(CommentType::class,$commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('menuUser');
        }

        return $this->render('user/laisserCommentaire.html.twig',[
                                    'seances'=>$rendezVousAll,
                                    'user'=>$userId,
                                    'form'=>$form->createView(),
                                    'etatNull'=>$etatNull,
                                    'etatConfirme'=>$etatConfirme
        ]);
    }



    /**
     * @Route ("/profile/laisser_commentaire/{id}",name="editCommentaire")
     */
    public function editCommentaire($id, UserInterface $user, Request $request, EntityManagerInterface $em)
    {
        //récupère l'Etat 'null' pour afficher seulement les séances sans commentaires
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatNull = $etatRepo->find(1);
        $etatConfirme = $etatRepo->find(4)->getId();

        //récupère l'Etat 'null' pour afficher seulement les séances sans commentaires
        $etatAttente = $etatRepo->find(2);

        //récupère la séance dont l'id est dans l'url
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seanceCommente = $seanceRepo->find($id);
        $seanceEtat = $seanceCommente->getNoEtatCommentaire();
        $seanceEtatConfirme = $seanceCommente->getNoEtatSeance()->getid();


        $commentaire = new Commentaire();
        $commentaire->setNoUtilisateur($user);
        $commentaire->setNoSeance($seanceCommente);
        $commentaire->setNoEtat($etatAttente);
        $seanceCommente->setNoEtatCommentaire($etatAttente);

        $userId = $user->getId();

        $rendezVousrepo= $this->getDoctrine()->getRepository(RendezVous::class);
        $rendezVousAll=$rendezVousrepo->findAll();

        $form = $this->createForm(CommentType::class,$commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Merci d\'avoir partagé votre expérience. A très bientôt');
            return $this->redirectToRoute('menuUser');
        }


        $seanceId = $seanceCommente->getNoUtilisateur()->getId();
        if ($userId === $seanceId && $seanceEtat == $etatNull && $seanceEtatConfirme == $etatConfirme)
        {
            return $this->render('user/laisserCommentaireId.html.twig',[
                'seances'=>$rendezVousAll,
                'user'=>$userId,
                'form'=>$form->createView(),
                'etatNull'=>$etatNull,
                'etatConfirme'=>$etatConfirme,
                'seanceCommente'=>$seanceCommente
            ]);
        }
        else
        {
            $this->addFlash('error','Vous ne pouvez pas laisser de commentaire pour cette séance');
            return $this->redirectToRoute('menuUser');
        }

    }
}
