<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;
    

/*********************************************************/

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Prestation",inversedBy="prestations")
     */
    private $noPrestation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur",inversedBy="rendezVous")
     * @ORM\JoinColumn (onDelete="CASCADE")
     */
    private $noUtilisateur;


    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="noSeance")
     */
    private $commentaires;


    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="seances")
     */
    private $noEtatCommentaire;

    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="etatSeances")
     */
    private $noEtatSeance;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\FormuleIntitule",inversedBy="formuleIntitule")
     */
    private $noFormuleIntitule;


    /**
     * @ORM\OneToMany (targetEntity=Photo::class, mappedBy="noRendezVous")
     */
    private $photosSeance;

    /*************************************************************/

    public function __construct()
    {
        $this->photosSeance = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }


    /***************************************************************/
    /**
     * @return mixed
     */
    public function getNoUtilisateur()
    {
        return $this->noUtilisateur;
    }

    /**
     * @param mixed $noUtilisateur
     */
    public function setNoUtilisateur($noUtilisateur): void
    {
        $this->noUtilisateur = $noUtilisateur;
    }

    /**
     * @return Prestation
     */
    public function getNoPrestation()
    {
        return $this->noPrestation;
    }

    /**
     * @param Prestation $noPrestation
     */
    public function setNoPrestation($noPrestation): void
    {
        $this->noPrestation = $noPrestation;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNoEtatCommentaire()
    {
        return $this->noEtatCommentaire;
    }

    /**
     * @param mixed $noEtatCommentaire
     */
    public function setNoEtatCommentaire($noEtatCommentaire): void
    {
        $this->noEtatCommentaire = $noEtatCommentaire;
    }

    /**
     * @return mixed
     */
    public function getNoEtatSeance()
    {
        return $this->noEtatSeance;
    }

    /**
     * @param mixed $noEtatSeance
     */
    public function setNoEtatSeance($noEtatSeance): void
    {
        $this->noEtatSeance = $noEtatSeance;
    }

    /**
     * @return mixed
     */
    public function getNoFormuleIntitule()
    {
        return $this->noFormuleIntitule;
    }

    /**
     * @param mixed $noFormuleIntitule
     */
    public function setNoFormuleIntitule($noFormuleIntitule): void
    {
        $this->noFormuleIntitule = $noFormuleIntitule;
    }

}
