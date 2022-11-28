<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Travaux
 *
 * @ORM\Table(name="travaux", indexes={@ORM\Index(name="travaux_type_travaux_FK", columns={"id_travaux_type_travaux"}), @ORM\Index(name="travaux_chambre0_FK", columns={"numero_chambre"})})
 * @ORM\Entity
 */
class Travaux
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_travaux", type="text", length=0, nullable=false)
     */
    private $commentaireTravaux;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity="Chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numero_chambre", referencedColumnName="numero_chambre")
     * })
     */
    private $numeroChambre;

    /**
     * @var \TypeTravaux
     *
     * @ORM\ManyToOne(targetEntity="TypeTravaux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_travaux_type_travaux", referencedColumnName="id_travaux")
     * })
     */
    private $idTravauxTypeTravaux;


}
