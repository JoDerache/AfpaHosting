<?php

namespace App\Entity;

use App\Entity\Personne;
use App\Entity\Financeur;
use App\Entity\Formations;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="participation_personne0_FK", columns={"id_personne"}), @ORM\Index(name="participation_financeur1_FK", columns={"id_financeur"}), @ORM\Index(name="IDX_AB55E24FC0759D98", columns={"id_formation"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository") 
 */
class Participation
{
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
     * @var \Financeur
     *
     * @ORM\ManyToOne(targetEntity="Financeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_financeur", referencedColumnName="id_financeur")
     * })
     */
    private $idFinanceur;

    /**
     * @var \Formations
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Formations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formation", referencedColumnName="id_formation")
     * })
     */
    private $idFormation;

    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

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

    public function getIdFinanceur(): ?Financeur
    {
        return $this->idFinanceur;
    }

    public function setIdFinanceur(?Financeur $idFinanceur): self
    {
        $this->idFinanceur = $idFinanceur;

        return $this;
    }

    public function getIdFormation(): ?Formations
    {
        return $this->idFormation;
    }

    public function setIdFormation(?Formations $idFormation): self
    {
        $this->idFormation = $idFormation;

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


}
