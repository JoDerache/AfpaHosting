<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Login
 *
 * @ORM\Table(name="login")
 * @ORM\Entity(repositoryClass="App\Repository\LoginRepository") 
 */
class Login
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_login", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLogin;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_beneficiaire", type="integer", nullable=false)
     */
    private $numeroBeneficiaire;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=100, nullable=false, options={"fixed"=true})
     */
    private $mdp;

    public function getIdLogin(): ?int
    {
        return $this->idLogin;
    }

    public function getNumeroBeneficiaire(): ?int
    {
        return $this->numeroBeneficiaire;
    }

    public function setNumeroBeneficiaire(int $numeroBeneficiaire): self
    {
        $this->numeroBeneficiaire = $numeroBeneficiaire;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }


}
