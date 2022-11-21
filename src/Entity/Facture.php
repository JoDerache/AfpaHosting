<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="facture_type_paiement0_FK", columns={"id_paiement"}), @ORM\Index(name="facture_bail_FK", columns={"id_bail"})})
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository") 
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

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function getNumeroFacture(): ?int
    {
        return $this->numeroFacture;
    }

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getMontantDejaReglee(): ?int
    {
        return $this->montantDejaReglee;
    }

    public function setMontantDejaReglee(int $montantDejaReglee): self
    {
        $this->montantDejaReglee = $montantDejaReglee;

        return $this;
    }

    public function getMontantAPercevoir(): ?int
    {
        return $this->montantAPercevoir;
    }

    public function setMontantAPercevoir(int $montantAPercevoir): self
    {
        $this->montantAPercevoir = $montantAPercevoir;

        return $this;
    }

    public function getDateDePaiement(): ?\DateTimeInterface
    {
        return $this->dateDePaiement;
    }

    public function setDateDePaiement(\DateTimeInterface $dateDePaiement): self
    {
        $this->dateDePaiement = $dateDePaiement;

        return $this;
    }

    public function getDateFacturation(): ?\DateTimeInterface
    {
        return $this->dateFacturation;
    }

    public function setDateFacturation(\DateTimeInterface $dateFacturation): self
    {
        $this->dateFacturation = $dateFacturation;

        return $this;
    }

    public function getIdBail(): ?Bail
    {
        return $this->idBail;
    }

    public function setIdBail(?Bail $idBail): self
    {
        $this->idBail = $idBail;

        return $this;
    }

    public function getIdPaiement(): ?TypePaiement
    {
        return $this->idPaiement;
    }

    public function setIdPaiement(?TypePaiement $idPaiement): self
    {
        $this->idPaiement = $idPaiement;

        return $this;
    }


}
