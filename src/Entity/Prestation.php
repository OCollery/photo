<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=PrestationRepository::class)
 * @Vich\Uploadable()
 */
class Prestation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\column(type="boolean")
     */
    private $menuDeroulant;

    /**
     * @var string|null
     * @ORM\Column (type="string", length=50)
     */
    private $filename;

    /**
     * @var File | null
     * @Vich\UploadableField(mapping="prestation_pdf",fileNameProperty="filename")
     */
    private $imageFile;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;


/**************************************************************************************/

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="noPrestation")
     */
    private $prestations;

    /**
     * @ORM\OneToMany(targetEntity=PhotoPrestation::class, mappedBy="noPrestation")
     */
    private $photosPrestation;

    /**
     * @ORM\OneToMany (targetEntity=Renseignement::class, mappedBy="noPrestation")
     */
    private $renseignementsPrestation;


    /**
     * @ORM\OneToMany(targetEntity=Formule::class, mappedBy="noPrestation")
     */
    private $prestationsFormule;


    /**
     * @ORM\OneToMany(targetEntity=CommentaireAnonyme::class, mappedBy="noPrestation")
     */
    private $prestationsCommentaireAnonyme;

/*************************************************************/

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
        $this->photosPrestation = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }


/************************************************************/



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


    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Prestation
     */
    public function setFilename(?string $filename): Prestation
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
     * @return Prestation
     */
    public function setImageFile(?File $imageFile): Prestation
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuDeroulant()
    {
        return $this->menuDeroulant;
    }

    /**
     * @param mixed $menuDeroulant
     */
    public function setMenuDeroulant($menuDeroulant): void
    {
        $this->menuDeroulant = $menuDeroulant;
    }

}
