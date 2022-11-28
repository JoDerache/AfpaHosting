<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parametre
 *
 * @ORM\Table(name="parametre")
 * @ORM\Entity(repositoryClass="App\Repository\ParametreRepository") 
 */
class Parametre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_parametre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParametre;

    /**
     * @var string
     *
     * @ORM\Column(name="loyer", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $loyer;

    /**
     * @var string
     *
     * @ORM\Column(name="caution", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $caution;

    public function getIdParametre(): ?int
    {
        return $this->idParametre;
    }

    public function getLoyer(): ?string
    {
        return $this->loyer;
    }

    public function setLoyer(string $loyer): self
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getCaution(): ?string
    {
        return $this->caution;
    }

    public function setCaution(string $caution): self
    {
        $this->caution = $caution;

        return $this;
    }


}
