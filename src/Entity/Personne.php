<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne", uniqueConstraints={@ORM\UniqueConstraint(name="personne_login_AK", columns={"id_login"})})
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository") 
 */
class Personne
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_personne", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_postale", type="string", length=255, nullable=false)
     */
    private $adressePostale;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="badge", type="string", length=255, nullable=false)
     */
    private $badge;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_beneficiaire", type="string", length=50, nullable=false)
     */
    private $numeroBeneficiaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_blacklisted", type="boolean", nullable=false)
     */
    private $isBlacklisted;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_naissance", type="string", length=255, nullable=false)
     */
    private $lieuNaissance;

    /**
     * @var \Login
     *
     * @ORM\ManyToOne(targetEntity="Login")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_login", referencedColumnName="id_login")
     * })
     */
    private $idLogin;

    public function getIdPersonne(): ?int
    {
        return $this->idPersonne;
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

    public function getAdressePostale(): ?string
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(string $adressePostale): self
    {
        $this->adressePostale = $adressePostale;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function setBadge(string $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getNumeroBeneficiaire(): ?string
    {
        return $this->numeroBeneficiaire;
    }

    public function setNumeroBeneficiaire(string $numeroBeneficiaire): self
    {
        $this->numeroBeneficiaire = $numeroBeneficiaire;

        return $this;
    }

    public function isIsBlacklisted(): ?bool
    {
        return $this->isBlacklisted;
    }

    public function setIsBlacklisted(bool $isBlacklisted): self
    {
        $this->isBlacklisted = $isBlacklisted;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getIdLogin(): ?Login
    {
        return $this->idLogin;
    }

    public function setIdLogin(?Login $idLogin): self
    {
        $this->idLogin = $idLogin;

        return $this;
    }


}
