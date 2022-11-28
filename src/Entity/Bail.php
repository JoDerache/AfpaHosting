<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bail
 *
 * @ORM\Table(name="bail", indexes={@ORM\Index(name="bail_chambre_FK", columns={"numero_chambre"}), @ORM\Index(name="bail_personne0_FK", columns={"id_personne"})})
 * @ORM\Entity
 */
class Bail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_bail", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entree", type="date", nullable=false)
     */
    private $dateEntree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sortie", type="date", nullable=false)
     */
    private $dateSortie;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity="Chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_chambre", referencedColumnName="numero_chambre")
     * })
     */
    private $numeroChambre;


}
