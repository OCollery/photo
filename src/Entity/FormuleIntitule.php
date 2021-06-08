<?php

namespace App\Entity;

use App\Repository\FormuleIntituleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormuleIntituleRepository::class)
 */
class FormuleIntitule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

/**************************************************/

    /**
     * @ORM\OneToMany(targetEntity=Formule::class, mappedBy="noFormule")
     */
    private $prestations;

    /**
     * @ORM\OneToMany (targetEntity=Renseignement::class, mappedBy="noFormule")
     */
    private $renseignementsFormule;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="noFormuleIntitule")
     */
    private $formuleIntitule;

/********************************************/

    public function __toString()
    {
        return $this->nom;
    }










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
}
