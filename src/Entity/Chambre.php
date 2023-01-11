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
     * @var \Etage
     *
     * @ORM\ManyToOne(targetEntity="Etage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_etage", referencedColumnName="numero_etage")
     * })
     */
    private $numeroEtage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

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


    public function getNumeroEtage(): ?Etage
    {
        return $this->numeroEtage;
    }

    public function setNumeroEtage(?Etage $numeroEtage): self
    {
        $this->numeroEtage = $numeroEtage;

        return $this;
    }
    public function __toString(): string
    {
        return $this->numeroChambre;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}
