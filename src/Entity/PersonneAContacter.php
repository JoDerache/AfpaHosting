<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonneAContacter
 *
 * @ORM\Table(name="personne_a_contacter", indexes={@ORM\Index(name="personne_a_contacter_personne_FK", columns={"id_personne"})})
 * @ORM\Entity
 */
class PersonneAContacter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_personne_contact", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPersonneContact;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="telephone", type="integer", nullable=false)
     */
    private $telephone;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;


}
