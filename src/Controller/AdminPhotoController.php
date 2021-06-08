<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Photo;
use App\Entity\PhotoPrestation;
use App\Entity\Prestation;
use App\Entity\RendezVous;
use App\Form\PhotoPrestationType;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin_", name="admin_")
 */
class AdminPhotoController extends AbstractController
{

    /**
     * @Route ("/ajouter_photos",name="ajouterPhoto")
     */
    public function ajoutPhoto()
    {

        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seances = $seanceRepo->findAll();

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations = $prestationRepo->findAll();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatConfirme = $etatRepo->find(4);

        return $this->render('admin_photo/AjouterPhoto.html.twig',[
            'seances'=>$seances,
            'etatConfirme'=>$etatConfirme,
            'prestations'=>$prestations
        ]);
    }


    /**
     * @Route ("ajouter_photo_utilisateur{id}",name="ajoutPhotoUtilisateur")
     */
    public function ajoutPhotoUtilisateur($id, EntityManagerInterface $em, Request $request)
    {
        $photo = new Photo();

        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seance = $seanceRepo->find($id);
        $seanceId = $seanceRepo->find($id)->getId();
        $utilisateur = $seanceRepo->find($id)->getNoUtilisateur();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatAttente = $etatRepo->find(2);
        $etatConfirme = $etatRepo->find(4);
        $etatChoisi = $etatRepo->find(7);
        $etatTelechargeable = $etatRepo->find(8);

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photos = $photoRepo->findAll();

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        $photo->setNoRendezVous($seance);
        $photo->setNoUtilisateur($utilisateur);
        $photo->setNoEtat($etatAttente);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('admin_ajoutPhotoUtilisateur',[
                'id'=>$seanceId
            ]);
        }

        return $this->render('admin_photo/AjouterPhotoUtilisateur.html.twig',[
            'form'=>$form->createView(),
            'seance'=>$seance,
            'etatConfirme'=>$etatConfirme,
            'etatAttente'=>$etatAttente,
            'etatChoisi'=>$etatChoisi,
            'utilisateur'=>$utilisateur,
            'etatTelechargeable'=>$etatTelechargeable,
            'photos'=>$photos
        ]);
    }





    /**
     * @Route ("/SupprimerPhotoUtilisateur{id}_{seanceId}",name="supprimerPhotoUtilisateur")
     */
    public function supprimerPhotoUtilisateur($id, $seanceId, EntityManagerInterface $em)
    {
        $seanceRepo = $this->getDoctrine()->getRepository(RendezVous::class);
        $seanceId = $seanceRepo->find($seanceId)->getId();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $photoRepo->find($id);

        $em->remove($photo);
        $em->flush();

        return $this->redirectToRoute('admin_ajoutPhotoUtilisateur',[
            'id'=>$seanceId
        ]);
    }


    /**
     * @Route ("ajouter_photo_prestation_{id}",name="ajoutPhotoPrestation")
     */
    public function ajoutPhotoPrestation($id, EntityManagerInterface $em, Request $request)
    {
        $photo = new PhotoPrestation();

        $photoRepo = $this->getDoctrine()->getRepository(PhotoPrestation::class);
        $photos = $photoRepo->findAll();

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($id);
        $prestationId = $prestationRepo->find($id)->getId();

        $etatRepo = $this->getDoctrine()->getRepository(Etat::class);
        $etatConfirme = $etatRepo->find(4);

        $form = $this->createForm(PhotoPrestationType::class, $photo);
        $form->handleRequest($request);

        $photo->setNoPrestation($prestation);


        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('admin_ajoutPhotoPrestation',[
                //'prestation'=>$prestation,
                'id'=>$prestationId
            ]);
        }

        return $this->render('admin_photo/AjouterPhotoPrestation.html.twig',[
            'form'=>$form->createView(),
            'etatConfirme'=>$etatConfirme,
            'photos'=>$photos,
            'prestation'=>$prestation
        ]);
    }


    /**
     * @Route ("supprimer_photo_prestation{id}_{prestationId}",name="supprimerPhotoPrestation")
     */
    public function supprimerPhotoPrestation($id, $prestationId, EntityManagerInterface $em)
    {
        $photoRepo = $this->getDoctrine()->getRepository(PhotoPrestation::class);
        $photo = $photoRepo->find($id);

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($prestationId)->getId();

        $em->remove($photo);
        $em->flush();

        return $this->redirectToRoute('admin_ajoutPhotoPrestation',[
            'id'=>$prestation
        ]);
    }
}
