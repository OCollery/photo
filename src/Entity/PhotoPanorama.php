<?php

namespace App\Entity;

use App\Repository\PhotoPanoramaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PhotoPanoramaRepository::class)
 * @Vich\Uploadable()
 */
class PhotoPanorama
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column (type="string", length=20)
     */
    private $filename;

    /**
     * @var File | null
     * @Vich\UploadableField(mapping="panorama_image",fileNameProperty="filename")
     */
    private $imageFile;

/***********************************************/

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
     * @return PhotoPanorama
     */
    public function setFilename(?string $filename): PhotoPanorama
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
     * @return PhotoPanorama
     */
    public function setImageFile(?File $imageFile): PhotoPanorama
    {
        $this->imageFile = $imageFile;
        return $this;
    }


}
