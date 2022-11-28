<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeTravaux
 *
 * @ORM\Table(name="type_travaux")
 * @ORM\Entity
 */
class TypeTravaux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_travaux", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTravaux;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_travaux", type="string", length=255, nullable=false)
     */
    private $nomTravaux;


}
