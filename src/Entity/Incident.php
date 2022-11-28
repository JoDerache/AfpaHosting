<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incident
 *
 * @ORM\Table(name="incident", indexes={@ORM\Index(name="incident_type_incident0_FK", columns={"id_type_incident"}), @ORM\Index(name="incident_bail_FK", columns={"id_bail"})})
 * @ORM\Entity
 */
class Incident
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_incident", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idIncident;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=0, nullable=false)
     */
    private $commentaire;

    /**
     * @var \TypeIncident
     *
     * @ORM\ManyToOne(targetEntity="TypeIncident")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_incident", referencedColumnName="id_type_incident")
     * })
     */
    private $idTypeIncident;

    /**
     * @var \Bail
     *
     * @ORM\ManyToOne(targetEntity="Bail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bail", referencedColumnName="id_bail")
     * })
     */
    private $idBail;


}
