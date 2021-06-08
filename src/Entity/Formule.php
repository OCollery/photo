<?php

namespace App\Entity;

use App\Repository\FormuleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormuleRepository::class)
 */
class Formule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $prix;

    /**
     * @ORM\Column(type="text")
     */
    private $detail;

    /**************************************************/

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Prestation",inversedBy="prestationsFormule")
     */
    private $noPrestation;


    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\FormuleIntitule",inversedBy="prestations")
     */
    private $noFormule;

/****************************************************/

    public function __toString()
    {
        return $this->noFormule->getNom();
    }

/****************************************************/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

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
