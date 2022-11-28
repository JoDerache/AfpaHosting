<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypePaiement
 *
 * @ORM\Table(name="type_paiement")
 * @ORM\Entity
 */
class TypePaiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_paiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_paiement", type="string", length=50, nullable=false)
     */
    private $nomPaiement;


}
