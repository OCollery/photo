<?php

namespace App\Controller;


use App\Controller\Modale\FenetreModale;
use App\Entity\Commentaire;
use App\Entity\CommentaireAnonyme;
use App\Entity\Etat;
use App\Entity\Formule;
use App\Entity\Photo;
use App\Entity\PhotoPanorama;
use App\Entity\PhotoPrestation;
use App\Entity\Prestation;
use App\Entity\Renseignement;
use App\Entity\Utilisateur;
use App\Form\CommentaireAnonymeType;
use App\Form\CommentType;
use App\Form\RenseignementType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, EntityManagerInterface $em): Response
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations = $prestationRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();


        //Fonction pour fenêtre modale demande de renseignement
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $formModal = $this->createForm(RenseignementType::class, $renseignement);
        $formModal->handleRequest($request);

        if ($formModal->isSubmitted() && $formModal->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        //Fin fonction fenêtre modale demande de renseignement

        return $this->render('main/home.html.twig',[
            'prestations'=>$prestations,
            'photos'=>$photos,
            'formModal'=>$formModal->createView()//permet d'afficher le formulaire dans la fenêtre modal
        ]);
    }


    /**
     * @Route ("/affichage_prestation_{prestation}_{id}",name="affichage_prestation")
     */
    public function affichagePrestation($id, EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($id);
        $prestations= $prestationRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPrestation::class);
        $photoPrestation = $photoRepo->findAll();

        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatPublie = $etatRepo->find(3);


        $formuleRepo = $this->getDoctrine()->getRepository(Formule::class);
        $formules = $formuleRepo->findAll();


        //Fonction pour denêtre du modale
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $formModal = $this->createForm(RenseignementType::class, $renseignement);
        $formModal->handleRequest($request);

        if ($formModal->isSubmitted() && $formModal->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        //Fin fonction pour denêtre du modale



        return $this->render('prestations/affichagePrestation.html.twig',[
            'prestation'=>$prestation,
            'prestations'=>$prestations,
            'photoPrestation'=>$photoPrestation,
            'photos'=>$photos,
            'commentaires'=>$commentaires,
            'etatPublie'=>$etatPublie,
            'formules'=>$formules,
            'formModal'=>$formModal->createView()
        ]);
    }


    /**
     * @Route ("/pack_prestation", name="packPrestation")
     */
    public function packPresta()
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations = $prestationRepo->findAll();

        return $this->render('prestations/packPrestation.html.twig',[
            'prestations'=>$prestations
        ]);
    }


    /**
     * @Route ("/livre_or",name="livreOr")
     */
   /* public function list()
    {
        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->recupererAllComment();



        return $this->render('main/livreOr.html.twig',[
            'commentaires'=>$commentaires
        ]);
    }*/


    public function livreOr(Request $request, EntityManagerInterface $em)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations= $prestationRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();

        $commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->recupererAllComment();


        /*$commentaireRepo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $commentaireRepo->findAll();*/

        $commentaireAnonymeRepo = $this->getDoctrine()->getRepository(CommentaireAnonyme::class);
        $commentairesAnonymes = $commentaireAnonymeRepo->findAll();


        //Fonction pour denêtre du modale "renseignement"
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $formModal = $this->createForm(RenseignementType::class, $renseignement);
        $formModal->handleRequest($request);

        if ($formModal->isSubmitted() && $formModal->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        //Fin fonction pour denêtre du modale


        //Fonction pour denêtre du modale "commentaire"
        $commentaire = new CommentaireAnonyme();

        $formCommentaire = $this->createForm(CommentaireAnonymeType::class, $commentaire);
        $formCommentaire->handleRequest($request);

        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid())
        {
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('livreOr');
        }


        //Fin fonction pour denêtre du modale


        return $this->render('main/livreOr.html.twig',[
            'prestations'=>$prestations,
            'photos'=>$photos,
            'commentaires'=>$commentaires,
            'formModal'=>$formModal->createView(),
            'formCommentaire'=>$formCommentaire->createView(),
            'commentairesAnonymes'=>$commentairesAnonymes
        ]);
    }




    /**
     * @Route ("/contact",name="contact")
     */
    public function contact(EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations= $prestationRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();



        //Fonction pour denêtre du modale
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $formModal = $this->createForm(RenseignementType::class, $renseignement);
        $formModal->handleRequest($request);

        if ($formModal->isSubmitted() && $formModal->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        //Fin fonction pour denêtre du modale





        return $this->render('main/contact.html.twig',[
            'prestations'=>$prestations,
            'photos'=>$photos,
            'formModal'=>$formModal->createView()
        ]);
    }


    /**
     * @Route ("/espace_utilisateur", name="menuUser")
     */
    public function menuUser(UserInterface $user)
    {
        $userId = $user->getId();//voir si utile

        return $this->render('user/MenuUser.html.twig');
    }



    //VOIR POUR INTEGRER CETTE FONCTION SANS LA COPIER COLLER
    public function renseignement(EntityManagerInterface $em, Request $request)
    {
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $form = $this->createForm(RenseignementType::class, $renseignement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('main/home.html.twig',[
        'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/un_peu_de_moi", name="unPeuDeMoi")
     */
    public function presentation(EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations= $prestationRepo->findAll();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPanorama::class);
        $photos = $photoRepo->findAll();


        //Fonction pour denêtre du modale
        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);

        $renseignement = new Renseignement();

        $renseignement->setDateRenseignement(new \DateTime());
        $renseignement->setNoEtatRenseignement($etatAttente);

        $formModal = $this->createForm(RenseignementType::class, $renseignement);
        $formModal->handleRequest($request);

        if ($formModal->isSubmitted() && $formModal->isValid())
        {
            $em->persist($renseignement);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        //Fin fonction pour denêtre du modale
        return $this->render('main/unPeuDeMoi.html.twig',[
            'prestations'=>$prestations,
            'photos'=>$photos,
            'formModal'=>$formModal->createView(),
        ]);
    }
}
