<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="Votre nom ne doit contenir que des lettres!")
     *
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="Votre prénom ne doit contenir que des lettres!")
     *
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @Assert\Email(message="Cette adresse mail existe déjà!")
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $mail;

    /**
     *@Assert\Length(
     *      min = 6,
     *      max = 64,
     *      minMessage = "Votre mot de passe doit contenir {{ limit }} caractères au minimum",
     *      maxMessage = "Votre mot de passe doit contenir {{ limit }} caractères au maximum"
     * )
     *
     * @ORM\Column(type="string", length=64)
     */
    private $motPasse;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column (type="date",nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\column(type="boolean")
     */
    private $admin;

/*****************************************************/
    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="noUtilisateur")
     */
    private $rendezVous;


    /**
     * @ORM\OneToMany (targetEntity=Photo::class, mappedBy="noUtilisateur")
     */
    private $photos;


    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="noUtilisateur")
     */
    private $commentaires;

/**************************************************/
    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

/***************************************************/

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = $admin;
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
    public function getMotPasse()
    {
        return $this->motPasse;
    }

    /**
     * @param mixed $motPasse
     */
    public function setMotPasse($motPasse): void
    {
        $this->motPasse = $motPasse;
    }



    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
    }



    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     */
    public function setDateNaissance($dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }




    public function getUsername(): string
    {
        return $this->mail;
    }

    public function getPassword(): ?string
    {
        return $this->motPasse;
    }



   public function getRoles()
    {
        $roles = array('ROLE_USER');

        if ($this->admin) {
            $roles[] = 'ROLE_ADMIN';
        }

        return $roles;
    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }
}
