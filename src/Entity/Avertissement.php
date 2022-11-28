<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Avertissement
 *
 * @ORM\Table(name="avertissement", uniqueConstraints={@ORM\UniqueConstraint(name="avertissement_incident_AK", columns={"id_incident"})})
 * @ORM\Entity(repositoryClass="App\Repository\AvertissementRepository") 
 */
class Avertissement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_avertissement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAvertissement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_avertissement", type="date", nullable=false)
     */
    private $dateAvertissement;

    /**
     * @var \Incident
     *
     * @ORM\ManyToOne(targetEntity="Incident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_incident", referencedColumnName="id_incident")
     * })
     */
    private $idIncident;

    public function getIdAvertissement(): ?int
    {
        return $this->idAvertissement;
    }

    public function getDateAvertissement(): ?\DateTimeInterface
    {
        return $this->dateAvertissement;
    }

    public function setDateAvertissement(\DateTimeInterface $dateAvertissement): self
    {
        $this->dateAvertissement = $dateAvertissement;

        return $this;
    }

    public function getIdIncident(): ?Incident
    {
        return $this->idIncident;
    }

    public function setIdIncident(?Incident $idIncident): self
    {
        $this->idIncident = $idIncident;

        return $this;
    }


}
