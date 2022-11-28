<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etage
 *
 * @ORM\Table(name="etage")
 * @ORM\Entity
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


}
