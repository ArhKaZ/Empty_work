<?php

namespace App\Entity;

use App\Repository\MatierePremiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatierePremiereRepository::class)
 */
class MatierePremiere
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
     * @ORM\Column(type="string", length=255)
     */
    private $unite_mesure;

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
    private $prix_ht;

    /**
     * @ORM\OneToMany(targetEntity=StockMP::class, mappedBy="matiere_premiere", orphanRemoval=true, cascade={"persist"})
     */
    private $actionStock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="matierePremieres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $stock_sobele;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $stock_marjoris;

    public function __construct()
    {
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

    public function getUniteMesure(): ?string
    {
        return $this->unite_mesure;
    }

    public function setUniteMesure(string $unite_mesure): self
    {
        $this->unite_mesure = $unite_mesure;

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

    public function getPrixHt(): ?float
    {
        return $this->prix_ht;
    }

    public function setPrixHt(float $prix_ht): self
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    public function __toString(): string
    {
        return $this->ref;
    }

    /**
     * @return Collection|StockMP[]
     */
    public function getActionStock(): Collection
    {
        return $this->actionStock;
    }

    public function addActionStock(StockMP $actionStock): self
    {
        if (!$this->actionStock->contains($actionStock)) {
            $this->actionStock[] = $actionStock;
            $actionStock->setMatierePremiere($this);
        }

        return $this;
    }

    public function removeActionStock(StockMP $actionStock): self
    {
        if ($this->actionStock->removeElement($actionStock)) {
            // set the owning side to null (unless already changed)
            if ($actionStock->getMatierePremiere() === $this) {
                $actionStock->setMatierePremiere(null);
            }
        }

        return $this;
    }


    public function getEtat(): string
    {
        if ($this->stock_marjoris < $this->stock_sobele) $stockMin = $this->stock_marjoris;
        else $stockMin = $this->stock_sobele;

        if ($stockMin <= $this->seuil_critique) return 'danger';
        elseif ($this->$stockMin <= $this->seuil_alerte) return 'warning';
        else return 'success';
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getStockSobele(): ?float
    {
        return $this->stock_sobele;
    }

    public function setStockSobele(float $stock_sobele): self
    {
        $this->stock_sobele = $stock_sobele;

        return $this;
    }

    public function getStockMarjoris(): ?float
    {
        return $this->stock_marjoris;
    }

    public function setStockMarjoris(float $stock_marjoris): self
    {
        $this->stock_marjoris = $stock_marjoris;

        return $this;
    }

    public function opStockSobele(float $op): self
    {
        $this->stock_sobele += $op;
        return $this;
    }

    public function opStockMarjoris(float $op): self
    {
        $this->stock_marjoris += $op;
        return $this;
    }
}