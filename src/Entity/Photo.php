<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @Vich\Uploadable()
 */
class Photo
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
    private $telechargeable;

    /**
     * @var string|null
     * @ORM\Column (type="string", length=20)
     */
    private $filename;

    /**
     * @var File | null
     * @Vich\UploadableField(mapping="utilisateur_image",fileNameProperty="filename")
     */
    private $imageFile;

/****************************************************************/

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="photos")
     *@ORM\JoinColumn(onDelete="CASCADE")
     */
    private $noUtilisateur;


    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\RendezVous", inversedBy="photosSeance")
     */
    private $noRendezVous;

    /**
     * @ORM\ManyToOne (targetEntity="Etat",inversedBy="photo")
     */
    private $noEtat;

    /***********************************************************/

    /**
     * @return mixed
     */
    public function getNoRendezVous()
    {
        return $this->noRendezVous;
    }

    /**
     * @param mixed $noRendezVous
     */
    public function setNoRendezVous($noRendezVous): void
    {
        $this->noRendezVous = $noRendezVous;
    }



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


    public function getId(): ?int
    {
        return $this->id;
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
     * @return Photo
     */
    public function setFilename(?string $filename): Photo
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
     * @return Photo
     */
    public function setImageFile(?File $imageFile): Photo
    {
        $this->imageFile = $imageFile;
        return $this;
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

    /**
     * @return mixed
     */
    public function getTelechargeable()
    {
        return $this->telechargeable;
    }

    /**
     * @param mixed $telechargeable
     */
    public function setTelechargeable($telechargeable): void
    {
        $this->telechargeable = $telechargeable;
    }

    

}
