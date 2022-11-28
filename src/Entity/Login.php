<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Login
 *
 * @ORM\Table(name="login", uniqueConstraints={@ORM\UniqueConstraint(name="Existe", columns={"numero_beneficiaire"}), @ORM\UniqueConstraint(name="numero_beneficiaire", columns={"numero_beneficiaire"})})
 * @ORM\Entity
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

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, nullable=false)
     */
    private $role;


}
