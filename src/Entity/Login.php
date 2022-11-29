<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Login
 *
 * @ORM\Table(name="login", uniqueConstraints={@ORM\UniqueConstraint(name="Existe", columns={"numero_beneficiaire"}), @ORM\UniqueConstraint(name="numero_beneficiaire", columns={"numero_beneficiaire"})})
 * @ORM\Entity(repositoryClass="App\Repository\LoginRepository") 
 */
class Login implements UserInterface, PasswordAuthenticatedUserInterface, PasswordHasherAwareInterface
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

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, nullable=false)
     */
    private $role;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }



         //--------- UserInterface
    
    
    
        /**
    
         * The public representation of the user (e.g. a username, an email address, etc.)
    
         *
    
         * @see UserInterface
    
         */
    
        public function getUserIdentifier(): string
    
        {
    
            return (string) $this->numeroBeneficiaire;
    
        }
    
    
    
        /**
    
         * @see UserInterface
    
         */
    
        public function getRoles(): array
    
        {        
    
            // guarantee every user at least has ROLE_USER
    
            $roles[] = $this->role;
    
            return array_unique($roles);
    
        }
    
    
    
        /**
    
         * Returning a salt is only needed, if you are not using a modern
    
         * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
    
         *
    
         * @see UserInterface
    
         */
    
        public function getSalt(): ?string
    
        {
    
            return null;
    
        }
    
    
    
        /**
    
         * @see UserInterface
    
         */
    
        public function eraseCredentials()
    
        {
    
            // If you store any temporary, sensitive data on the user, clear it here
    
            // $this->plainPassword = null;
    
        }
    
    
    
        /**
    
         * @see PasswordAuthenticatedUserInterface
    
         */
    
        public function getPassword(): string
    
        {
    
            return $this->mdp;
    
        }
    
    
    
        public function getPasswordHasherName(): ?string
    
        {
    
            return null; // use the default hasher
    
        }

}
