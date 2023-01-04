<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bail
 *
 * @ORM\Table(name="bail", indexes={@ORM\Index(name="bail_chambre_FK", columns={"numero_chambre"}), @ORM\Index(name="bail_personne0_FK", columns={"id_personne"})})
 * @ORM\Entity(repositoryClass="App\Repository\BailRepository")  */
class Bail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bail", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entree", type="date", nullable=false)
     */
    private $dateEntree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sortie", type="date", nullable=false)
     */
    private $dateSortie;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity="Chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_chambre", referencedColumnName="numero_chambre")
     * })
     */
    private $numeroChambre;

    public function getIdBail(): ?int
    {
        return $this->idBail;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->idPersonne;
    }

    public function setIdPersonne(?Personne $idPersonne): self
    {
        $this->idPersonne = $idPersonne;

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

    public function __toString() : string 
    {
        return $this->getIdPersonne();
    }

}
