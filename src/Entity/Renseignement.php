<?php

namespace App\Entity;

use App\Repository\RenseignementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RenseignementRepository::class)
 */
class Renseignement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column (type="date")
     */
    private $dateRenseignement;

    /**
     * @ORM\Column (type="date")
     */
    private $dateSeance;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @Assert\Regex(pattern="/^[ a-z0-9_-]+$/i", message="Votre commentaire doit contenir uniquement des lettres, chiffres, underscores and tiret!")
     *
     * @ORM\Column(type="text",nullable=true)
     */
    private $detailProjet;

    /************************************************/

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Prestation",inversedBy="renseignementsPrestation")
     */
    private $noPrestation;


    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\FormuleIntitule",inversedBy="renseignementsFormule")
     */
    private $noFormule;


    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="etatRenseignement")
     */
    private $noEtatRenseignement;



    #################################################

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateRenseignement()
    {
        return $this->dateRenseignement;
    }

    /**
     * @param mixed $dateRenseignement
     */
    public function setDateRenseignement($dateRenseignement): void
    {
        $this->dateRenseignement = $dateRenseignement;
    }

    /**
     * @return mixed
     */
    public function getDateSeance()
    {
        return $this->dateSeance;
    }

    /**
     * @param mixed $dateSeance
     */
    public function setDateSeance($dateSeance): void
    {
        $this->dateSeance = $dateSeance;
    }


    /**
     * @return mixed
     */
    public function getNoPrestation()
    {
        return $this->noPrestation;
    }

    /**
     * @param mixed $noPrestation
     */
    public function setNoPrestation($noPrestation): void
    {
        $this->noPrestation = $noPrestation;
    }

    /**
     * @return mixed
     */
    public function getNoEtatRenseignement()
    {
        return $this->noEtatRenseignement;
    }

    /**
     * @param mixed $noEtatRenseignement
     */
    public function setNoEtatRenseignement($noEtatRenseignement): void
    {
        $this->noEtatRenseignement = $noEtatRenseignement;
    }


    /**
     * @return mixed
     */
    public function getDetailProjet()
    {
        return $this->detailProjet;
    }

    /**
     * @param mixed $detailProjet
     */
    public function setDetailProjet($detailProjet): void
    {
        $this->detailProjet = $detailProjet;
    }

    /**
     * @return mixed
     */
    public function getNoFormule()
    {
        return $this->noFormule;
    }

    /**
     * @param mixed $noFormule
     */
    public function setNoFormule($noFormule): void
    {
        $this->noFormule = $noFormule;
    }


}
