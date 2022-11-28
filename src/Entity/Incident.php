<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Incident
 *
 * @ORM\Table(name="incident", indexes={@ORM\Index(name="incident_type_incident0_FK", columns={"id_type_incident"}), @ORM\Index(name="incident_bail_FK", columns={"id_bail"})})
 * @ORM\Entity(repositoryClass="App\Repository\IncidentRepository")  */
class Incident
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_incident", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idIncident;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=0, nullable=false)
     */
    private $commentaire;

    /**
     * @var \TypeIncident
     *
     * @ORM\ManyToOne(targetEntity="TypeIncident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_incident", referencedColumnName="id_type_incident")
     * })
     */
    private $idTypeIncident;

    /**
     * @var \Bail
     *
     * @ORM\ManyToOne(targetEntity="Bail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bail", referencedColumnName="id_bail")
     * })
     */
    private $idBail;

    public function getIdIncident(): ?int
    {
        return $this->idIncident;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdTypeIncident(): ?TypeIncident
    {
        return $this->idTypeIncident;
    }

    public function setIdTypeIncident(?TypeIncident $idTypeIncident): self
    {
        $this->idTypeIncident = $idTypeIncident;

        return $this;
    }

    public function getIdBail(): ?Bail
    {
        return $this->idBail;
    }

    public function setIdBail(?Bail $idBail): self
    {
        $this->idBail = $idBail;

        return $this;
    }


}
