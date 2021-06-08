<?php

namespace App\Entity;

use App\Repository\CommentaireAnonymeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CommentaireAnonymeRepository::class)
 * @Vich\Uploadable
 */
class CommentaireAnonyme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSeance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroCommentaire;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

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
     * @ORM\ManyToOne (targetEntity="App\Entity\Prestation",inversedBy="prestationsCommentaireAnonyme")
     */
    private $noPrestation;

    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="commentairesAnonymes")
     */
    private $noEtat;

    /*******************************************************/
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

    public function getDateSeance(): ?\DateTimeInterface
    {
        return $this->dateSeance;
    }

    public function setDateSeance(?\DateTimeInterface $dateSeance): self
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getNumeroCommentaire(): ?int
    {
        return $this->numeroCommentaire;
    }

    public function setNumeroCommentaire(?int $numeroCommentaire): self
    {
        $this->numeroCommentaire = $numeroCommentaire;

        return $this;
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
     * @return CommentaireAnonyme
     */
    public function setFilename(?string $filename): CommentaireAnonyme
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
     * @return CommentaireAnonyme
     */
    public function setImageFile(?File $imageFile): CommentaireAnonyme
    {
        $this->imageFile = $imageFile;
        return $this;
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
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param mixed $commentaire
     */
    public function setCommentaire($commentaire): void
    {
        $this->commentaire = $commentaire;
    }

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


}
