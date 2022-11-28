<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 *
 * @ORM\Table(name="chambre", indexes={@ORM\Index(name="chambre_etage_FK", columns={"numero_etage"})})
 * @ORM\Entity(repositoryClass="App\Repository\ChambreRepository")  */
class Chambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="numero_chambre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeroChambre;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_clefs", type="string", length=10, nullable=false)
     */
    private $numeroClefs;

    /**
     * @var bool
     *
     * @ORM\Column(name="condamne", type="boolean", nullable=false)
     */
    private $condamne;

    /**
     * @var \Etage
     *
     * @ORM\ManyToOne(targetEntity="Etage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_etage", referencedColumnName="numero_etage")
     * })
     */
    private $numeroEtage;

    public function getNumeroChambre(): ?int
    {
        return $this->numeroChambre;
    }

    public function getNumeroClefs(): ?string
    {
        return $this->numeroClefs;
    }

    public function setNumeroClefs(string $numeroClefs): self
    {
        $this->numeroClefs = $numeroClefs;

        return $this;
    }

    public function isCondamne(): ?bool
    {
        return $this->condamne;
    }

    public function setCondamne(bool $condamne): self
    {
        $this->condamne = $condamne;

        return $this;
    }

    public function getNumeroEtage(): ?Etage
    {
        return $this->numeroEtage;
    }

    public function setNumeroEtage(?Etage $numeroEtage): self
    {
        $this->numeroEtage = $numeroEtage;

        return $this;
    }


}
