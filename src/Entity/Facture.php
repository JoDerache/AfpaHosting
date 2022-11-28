<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="facture_type_paiement0_FK", columns={"id_paiement"}), @ORM\Index(name="facture_bail_FK", columns={"id_bail"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $annee;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numeroFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_total", type="integer", nullable=false)
     */
    private $montantTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_deja_reglee", type="integer", nullable=false)
     */
    private $montantDejaReglee;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_a_percevoir", type="integer", nullable=false)
     */
    private $montantAPercevoir;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_paiement", type="date", nullable=false)
     */
    private $dateDePaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_facturation", type="date", nullable=false)
     */
    private $dateFacturation;

    /**
     * @var \Bail
     *
     * @ORM\ManyToOne(targetEntity="Bail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bail", referencedColumnName="id_bail")
     * })
     */
    private $idBail;

    /**
     * @var \TypePaiement
     *
     * @ORM\ManyToOne(targetEntity="TypePaiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_paiement", referencedColumnName="id_paiement")
     * })
     */
    private $idPaiement;


}
