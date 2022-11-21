<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Travaux
 *
 * @ORM\Table(name="travaux", indexes={@ORM\Index(name="travaux_chambre0_FK", columns={"numero_chambre"}), @ORM\Index(name="travaux_type_travaux_FK", columns={"id_travaux_type_travaux"})})
 * @ORM\Entity(repositoryClass="App\Repository\TravauxRepository") 
 */
class Travaux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_travaux", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTravaux;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_travaux", type="text", length=0, nullable=false)
     */
    private $commentaireTravaux;

    /**
     * @var \TypeTravaux
     *
     * @ORM\ManyToOne(targetEntity="TypeTravaux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_travaux_type_travaux", referencedColumnName="id_travaux")
     * })
     */
    private $idTravauxTypeTravaux;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity="Chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_chambre", referencedColumnName="numero_chambre")
     * })
     */
    private $numeroChambre;

    public function getIdTravaux(): ?int
    {
        return $this->idTravaux;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getCommentaireTravaux(): ?string
    {
        return $this->commentaireTravaux;
    }

    public function setCommentaireTravaux(string $commentaireTravaux): self
    {
        $this->commentaireTravaux = $commentaireTravaux;

        return $this;
    }

    public function getIdTravauxTypeTravaux(): ?TypeTravaux
    {
        return $this->idTravauxTypeTravaux;
    }

    public function setIdTravauxTypeTravaux(?TypeTravaux $idTravauxTypeTravaux): self
    {
        $this->idTravauxTypeTravaux = $idTravauxTypeTravaux;

        return $this;
    }

    public function getNumeroChambre(): ?Chambre
    {
        return $this->numeroChambre;
    }

    public function setNumeroChambre(?Chambre $numeroChambre): self
    {
        $this->numeroChambre = $numeroChambre;

        return $this;
    }


}
