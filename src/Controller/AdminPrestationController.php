<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Entity\FormuleIntitule;
use App\Entity\Prestation;
use App\Form\FormuleIntituleType;
use App\Form\FormuleType;
use App\Form\PrestationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/admin_", name="admin_")
 */
class AdminPrestationController extends AbstractController
{

    /**
     * @Route ("/ajouter_prestation",name="ajouterPrestation")
     */
    public function ajouterPrestation(EntityManagerInterface $em, Request $request)
    {
        $prestation = new Prestation();

        $form = $this->createForm(PrestationType::class,$prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($prestation);
            $em->flush();

            return $this->redirectToRoute('admin_ajouterPrestation');
        }

        return $this->render('admin_prestation/AjouterTheme.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/modifier_prestation",name="listPrestation")
     **/
    public function listPrestation(EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestationAll = $prestationRepo->findAll();

        $form = $this->createForm(PrestationType::class);

        return $this->render('admin_prestation/ModifierPrestation.html.twig',[
            'prestations'=>$prestationAll,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/modifier_prestation/{id}",name="modifierPrestation")
     **/
    public function modifierPrestation($id, EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestationAll = $prestationRepo->findAll();

        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($id);

        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute('admin_listPrestation');
        }

        return $this->render('admin_prestation/ModifierPrestation.html.twig',[
            'prestations'=>$prestationAll,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route ("/supprimer-prestation{id}",name="supprimerPrestation")
     */
    public function supprimerPrestation($id, EntityManagerInterface $em)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestation = $prestationRepo->find($id);

        $em->remove($prestation);
        $em->flush();

        return $this->redirectToRoute('admin_modifierPrestation',[
            'id'=>$prestation
        ]);
    }


    /**
     * @Route ("/ajouter_formule",name="ajouterFormule")
     */
    public function ajouterFormule(EntityManagerInterface $em, Request $request)
    {
        $formule = new Formule();

        $form = $this->createForm(FormuleType::class,$formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($formule);
            $em->flush();

            return $this->redirectToRoute('admin_ajouterFormule');
        }


        return $this->render('admin_prestation/AjouterFormule.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/modifier_formule",name="listFormule")
     */
    public function listFormule()
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestationAll = $prestationRepo->findAll();

        $formuleRepo = $this->getDoctrine()->getRepository(Formule::class);
        $formules = $formuleRepo->findAll();

        $form = $this->createForm(FormuleType::class);


        return $this->render('admin_prestation/ModifierFormule.html.twig',[
            'formules'=>$formules,
            'form'=>$form->createView(),
            'prestations'=>$prestationAll
        ]);
    }


    /**
     * @Route ("/modifier_formule/{id}",name="modifierFormule")
     **/
    public function modifierFormule($id, EntityManagerInterface $em, Request $request)
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestationAll = $prestationRepo->findAll();

        $formuleRepo = $this->getDoctrine()->getRepository(Formule::class);
        $formuleAll = $formuleRepo->findAll();

        $formuleRepo = $this->getDoctrine()->getRepository(Formule::class);
        $formule = $formuleRepo->find($id);

        $form = $this->createForm(FormuleType::class, $formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute('admin_listFormule');
        }

        return $this->render('admin_prestation/ModifierFormule.html.twig',[
            'formules'=>$formuleAll,
            'form'=>$form->createView(),
            'prestations'=>$prestationAll
        ]);
    }


    /**
     * @Route ("/supprimer-formule{id}",name="supprimerFormule")
     */
    public function supprimerFormule($id, EntityManagerInterface $em)
    {
        $formuleRepo = $this->getDoctrine()->getRepository(Formule::class);
        $formule = $formuleRepo->find($id);

        $em->remove($formule);
        $em->flush();

        return $this->redirectToRoute('admin_modifierFormule',[
            'id'=>$formule
        ]);
    }
}
