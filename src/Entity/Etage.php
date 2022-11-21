<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etage
 *
 * @ORM\Table(name="etage")
 * @ORM\Entity(repositoryClass="App\Repository\EtageRepository") 
 */
class Etage
{
    /**
     * @var int
     *
     * @ORM\Column(name="numero_etage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeroEtage;

    /**
     * @var bool
     *
     * @ORM\Column(name="reserver_femme", type="boolean", nullable=false)
     */
    private $reserverFemme;

    public function getNumeroEtage(): ?int
    {
        return $this->numeroEtage;
    }

    public function isReserverFemme(): ?bool
    {
        return $this->reserverFemme;
    }

    public function setReserverFemme(bool $reserverFemme): self
    {
        $this->reserverFemme = $reserverFemme;

        return $this;
    }


}
