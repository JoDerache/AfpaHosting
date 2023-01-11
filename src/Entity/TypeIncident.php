<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeIncident
 *
 * @ORM\Table(name="type_incident")
 * @ORM\Entity(repositoryClass="App\Repository\TypeIncidentRepository")  */

class TypeIncident
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type_incident", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTypeIncident;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_type_incident", type="string", length=255, nullable=false)
     */
    private $nomTypeIncident;

    public function getIdTypeIncident(): ?int
    {
        return $this->idTypeIncident;
    }

    public function getNomTypeIncident(): ?string
    {
        return $this->nomTypeIncident;
    }

    public function setNomTypeIncident(string $nomTypeIncident): self
    {
        $this->nomTypeIncident = $nomTypeIncident;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getnomTypeIncident();
    }

}
