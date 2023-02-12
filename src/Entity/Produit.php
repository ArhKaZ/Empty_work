<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionArticle::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $collection;

    /**
     * @ORM\ManyToOne(targetEntity=Taille::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @var Taille
     */
    private $taille;

    /**
     * @ORM\Column(type="integer")
     */
    private $seuil_alerte;

    /**
     * @ORM\Column(type="integer")
     */
    private $seuil_critique;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_public;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_revendeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dans_catalogue;

    /**
     * @ORM\OneToMany(targetEntity=StockProduit::class, mappedBy="produit", orphanRemoval=true, cascade={"persist"})
     */
    private $actionStock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refCompta;

    public function getEtat(): string {
        if ($this->dans_catalogue) {
            if ($this->stock <= $this->seuil_critique) return 'danger';
            elseif ($this->stock <= $this->seuil_alerte) return 'warning';
            else return 'success';
        } else return 'secondary';
    }

    public function __construct()
    {
        $this->stock = 0;
        $this->actionStock = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getCollection(): ?CollectionArticle
    {
        return $this->collection;
    }

    public function setCollection(?CollectionArticle $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function opStock(int $op): self
    {
        $this->stock += $op;
        return $this;
    }

    public function getSeuilAlerte(): ?int
    {
        return $this->seuil_alerte;
    }

    public function setSeuilAlerte(int $seuil_alerte): self
    {
        $this->seuil_alerte = $seuil_alerte;

        return $this;
    }

    public function getSeuilCritique(): ?int
    {
        return $this->seuil_critique;
    }

    public function setSeuilCritique(int $seuil_critique): self
    {
        $this->seuil_critique = $seuil_critique;

        return $this;
    }

    public function getPrixPublic(): ?float
    {
        return $this->prix_public;
    }

    public function setPrixPublic(float $prix_public): self
    {
        $this->prix_public = $prix_public;

        return $this;
    }

    public function getPrixRevendeur(): ?float
    {
        return $this->prix_revendeur;
    }

    public function setPrixRevendeur(float $prix_revendeur): self
    {
        $this->prix_revendeur = $prix_revendeur;

        return $this;
    }

    public function getDansCatalogue(): ?bool
    {
        return $this->dans_catalogue;
    }

    public function setDansCatalogue(bool $dans_catalogue): self
    {
        $this->dans_catalogue = $dans_catalogue;

        return $this;
    }

    /**
     * @return Collection|StockProduit[]
     */
    public function getActionStock(): Collection
    {
        return $this->actionStock;
    }

    public function addActionStock(StockProduit $actionStock): self
    {
        if (!$this->actionStock->contains($actionStock)) {
            $this->actionStock[] = $actionStock;
            $actionStock->setProduit($this);
        }

        return $this;
    }

    public function removeActionStock(StockProduit $actionStock): self
    {
        if ($this->actionStock->removeElement($actionStock)) {
            // set the owning side to null (unless already changed)
            if ($actionStock->getProduit() === $this) {
                $actionStock->setProduit(null);
            }
        }

        return $this;
    }

    public function __toString(): string {
        return $this->ref;
    }

    public function getArticle(): Article {
        return $this->taille->getArticle();
    }

    public function getRefCompta(): ?string
    {
        return $this->refCompta;
    }

    public function setRefCompta(?string $refCompta): self
    {
        $this->refCompta = $refCompta;

        return $this;
    }

}
