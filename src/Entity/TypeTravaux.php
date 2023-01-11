<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeTravaux
 *
 * @ORM\Table(name="type_travaux")
 * @ORM\Entity(repositoryClass="App\Repository\TypeTravauxRepository")  
 */
class TypeTravaux
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
     * @var string
     *
     * @ORM\Column(name="nom_travaux", type="string", length=255, nullable=false)
     */
    private $nomTravaux;

    public function getIdTravaux(): ?int
    {
        return $this->idTravaux;
    }

    public function getNomTravaux(): ?string
    {
        return $this->nomTravaux;
    }

    public function setNomTravaux(string $nomTravaux): self
    {
        $this->nomTravaux = $nomTravaux;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nomTravaux;
    }

}
