<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="participation_financeur1_FK", columns={"id_financeur"}), @ORM\Index(name="participation_personne0_FK", columns={"id_personne"}), @ORM\Index(name="IDX_AB55E24FC0759D98", columns={"id_formation"})})
 * @ORM\Entity
 */
class Participation
{
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
     * @var \Financeur
     *
     * @ORM\ManyToOne(targetEntity="Financeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_financeur", referencedColumnName="id_financeur")
     * })
     */
    private $idFinanceur;

    /**
     * @var \Personne
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id_personne")
     * })
     */
    private $idPersonne;

    /**
     * @var \Formations
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Formations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formation", referencedColumnName="id_formation")
     * })
     */
    private $idFormation;


}
