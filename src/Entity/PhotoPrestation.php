<?php

namespace App\Entity;

use App\Repository\PhotoPrestationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as assert;

/**
 * @ORM\Entity(repositoryClass=PhotoPrestationRepository::class)
 * @Vich\Uploadable()
 */
class PhotoPrestation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column (type="string", length=50)
     */
    private $filename;

    /**
     * @var File | null
     * @Vich\UploadableField(mapping="prestation_image",fileNameProperty="filename")
     */
    private $imageFile;


    /*************************************************/

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Prestation",inversedBy="photosPrestation")
     * @ORM\JoinColumn (onDelete="CASCADE")
     */
    private $noPrestation;

/*************************************************/

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
     * @return PhotoPrestation
     */
    public function setFilename(?string $filename): PhotoPrestation
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
     * @return PhotoPrestation
     */
    public function setImageFile(?File $imageFile): PhotoPrestation
    {
        $this->imageFile = $imageFile;
        return $this;
    }

}
