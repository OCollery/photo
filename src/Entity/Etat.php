<?php

namespace App\Entity;

use App\Repository\EtatCommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatCommentaireRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $Etat;

/****************************************/

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="noEtat")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="noEtat")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireAnonyme::class, mappedBy="noEtat")
     */
    private $commentairesAnonymes;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="noEtatCommentaire")
     */
    private $seances;


    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="noEtatSeance")
     */
    private $etatSeances;


    /**
     * @ORM\OneToMany(targetEntity=Renseignement::class, mappedBy="noEtatRenseignement")
     */
    private $etatRenseignement;

    /*******************************************/

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->seances = new ArrayCollection();
        $this->etatSeances = new ArrayCollection();
    }

    /*****************************************/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }
}
