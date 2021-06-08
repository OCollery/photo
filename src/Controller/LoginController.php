<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Prestation;
use App\Entity\Renseignement;
use App\Form\RenseignementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $em): Response
    {
        $prestationRepo = $this->getDoctrine()->getRepository(Prestation::class);
        $prestations= $prestationRepo->findAll();

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();


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



        return $this->render('login/login.html.twig',['prestations'=>$prestations,
                                                            'last_username'=>$lastUsername,
                                                            'error'=>$error,
                                                            'formModal'=>$formModal->createView()
        ]);
    }

    /**
     * @Route ("/logout",name="logout")
     */
    public function logout(){}
}
