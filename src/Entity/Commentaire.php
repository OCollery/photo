<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @Vich\Uploadable
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;


    /**
     * @ORM\Column (type="integer",nullable=true)
     */
    private $numeroCommentaire;

/*******************************************************/

    /**
     * @var string|null
     * @ORM\Column (type="string", length=50)
     */
    private $filename;

    /**
     * @var File | null
     * @Vich\UploadableField(mapping="commentaire_image",fileNameProperty="filename")
     */
    private $imageFile;

/*******************************************************/
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RendezVous", inversedBy="commentaires")
     */
    private $noSeance;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Utilisateur",inversedBy="commentaires")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $noUtilisateur;

    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="commentaires")
     */
    private $noEtat;



/*******************************************************/
    /**
     * @return mixed
     */
    public function getNoEtat()
    {
        return $this->noEtat;
    }

    /**
     * @param mixed $noEtat
     */
    public function setNoEtat($noEtat): void
    {
        $this->noEtat = $noEtat;
    }

    /**
     * @return Utilisateur
     */
    public function getNoUtilisateur():Utilisateur
    {
        return $this->noUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getNoSeance()
    {
        return $this->noSeance;
    }

    /**
     * @param mixed $noSeance
     */
    public function setNoSeance($noSeance): void
    {
        $this->noSeance = $noSeance;
    }



    /**
     * @param Utilisateur $noUtilisateur
     */
    public function setNoUtilisateur(Utilisateur $noUtilisateur): void
    {
        $this->noUtilisateur = $noUtilisateur;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumeroCommentaire()
    {
        return $this->numeroCommentaire;
    }

    /**
     * @param mixed $numeroCommentaire
     */
    public function setNumeroCommentaire($numeroCommentaire): void
    {
        $this->numeroCommentaire = $numeroCommentaire;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Commentaire
     */
    public function setFilename(?string $filename): Commentaire
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Commentaire
     */
    public function setImageFile(?File $imageFile): Commentaire
    {
        $this->imageFile = $imageFile;
        return $this;
    }



}

