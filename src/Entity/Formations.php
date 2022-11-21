<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formations
 *
 * @ORM\Table(name="formations")
 * @ORM\Entity(repositoryClass="App\Repository\FormationsRepository") 
 */
class Formations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_formation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_formation", type="string", length=255, nullable=false)
     */
    private $nomFormation;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_offre", type="integer", nullable=false)
     */
    private $numeroOffre;

    public function getIdFormation(): ?int
    {
        return $this->idFormation;
    }

    public function getNomFormation(): ?string
    {
        return $this->nomFormation;
    }

    public function setNomFormation(string $nomFormation): self
    {
        $this->nomFormation = $nomFormation;

        return $this;
    }

    public function getNumeroOffre(): ?int
    {
        return $this->numeroOffre;
    }

    public function setNumeroOffre(int $numeroOffre): self
    {
        $this->numeroOffre = $numeroOffre;

        return $this;
    }


}
