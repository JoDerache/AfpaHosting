<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 *
 * @ORM\Table(name="chambre", indexes={@ORM\Index(name="chambre_etage_FK", columns={"numero_etage"})})
 * @ORM\Entity
 */
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


}
