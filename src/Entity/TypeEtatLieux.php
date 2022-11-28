<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEtatLieux
 *
 * @ORM\Table(name="type_etat_lieux")
 * @ORM\Entity
 */
class TypeEtatLieux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type_etat_lieux", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTypeEtatLieux;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_etat_lieux", type="string", length=30, nullable=false)
     */
    private $nomEtatLieux;


}
