<?php

namespace App\Entity;

use App\Repository\CommandeClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeClientRepository::class)
 */
class CommandeClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_livraison;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bon_livraison;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frais_livraison;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $annuler;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_paiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_vente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avoir_num;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $avoir_montant;

    /**
     * @ORM\OneToMany(targetEntity=CCProduit::class, mappedBy="commande", orphanRemoval=true, cascade={"persist"})
     */
    private $panier;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $remise;

    /**
     * @ORM\Column(type="float")
     */
    private $ttht;

    /**
     * @ORM\Column(type="float")
     */
    private $tva;

    /**
     * @ORM\Column(type="float")
     */
    private $ttc;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="prod_achete")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_facture;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
        $this->date_commande = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(?string $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(?string $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getBonLivraison(): ?string
    {
        return $this->bon_livraison;
    }

    public function setBonLivraison(?string $bon_livraison): self
    {
        $this->bon_livraison = $bon_livraison;

        return $this;
    }

    public function getFraisLivraison(): ?float
    {
        return $this->frais_livraison;
    }

    public function setFraisLivraison(?float $frais_livraison): self
    {
        $this->frais_livraison = $frais_livraison;

        return $this;
    }

    public function getAnnuler(): ?bool
    {
        return $this->annuler;
    }

    public function setAnnuler(?bool $annuler): self
    {
        $this->annuler = $annuler;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->type_paiement;
    }

    public function setTypePaiement(string $type_paiement): self
    {
        $this->type_paiement = $type_paiement;

        return $this;
    }

    public function getLieuVente(): ?string
    {
        return $this->lieu_vente;
    }

    public function setLieuVente(string $lieu_vente): self
    {
        $this->lieu_vente = $lieu_vente;

        return $this;
    }

    public function getAvoirNum(): ?string
    {
        return $this->avoir_num;
    }

    public function setAvoirNum(?string $avoir_num): self
    {
        $this->avoir_num = $avoir_num;

        return $this;
    }

    public function getAvoirMontant(): ?float
    {
        return $this->avoir_montant;
    }

    public function setAvoirMontant(?float $avoir_montant): self
    {
        $this->avoir_montant = $avoir_montant;

        return $this;
    }

    /**
     * @return Collection|CCProduit[]
     */
    public function getPanier(): Collection
    {
        return $this->panier;
    }

    public function addPanier(CCProduit $panier): self
    {
        if (!$this->panier->contains($panier)) {
            $this->panier[] = $panier;
            $panier->setCommande($this);
        }

        return $this;
    }

    public function removePanier(CCProduit $panier): self
    {
        if ($this->panier->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getCommande() === $this) {
                $panier->setCommande(null);
            }
        }

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }
    public function __toString(): string
    {
        return $this->id;
    }

    public function getTtht(): ?float
    {
        return $this->ttht;
    }

    public function setTtht(float $ttht): self
    {
        $this->ttht = $ttht;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTtc(): ?float
    {
        return $this->ttc;
    }

    public function setTtc(float $ttc): self
    {
        $this->ttc = $ttc;

        return $this;
    }

    public function getNumFacture(): ?Facture
    {
        return $this->num_facture;
    }

    public function setNumFacture(?Facture $num_facture): self
    {
        $this->num_facture = $num_facture;

        return $this;
    }
}
