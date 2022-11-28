<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne", uniqueConstraints={@ORM\UniqueConstraint(name="personne_login_AK", columns={"id_login"})})
 * @ORM\Entity
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


}
