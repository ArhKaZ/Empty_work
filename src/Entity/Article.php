<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @UniqueEntity("nom")
 */
class Article implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=Taille::class, mappedBy="article", orphanRemoval=true, cascade={"persist"})
     * @Assert\NotBlank()
     */
    private $tailles;

    /**
     * @ORM\ManyToMany(targetEntity=Fournisseur::class, inversedBy="coupes")
     * @ORM\JoinTable(name="fournisseur_article_coupe")
     */
    private $lieux_coupes;

    /**
     * @ORM\ManyToMany(targetEntity=Fournisseur::class, inversedBy="assembles")
     * @ORM\JoinTable(name="fournisseur_article_assemble")
     */
    private $lieux_assemblages;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_noeud;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref_compta;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
        $this->lieux_coupes = new ArrayCollection();
        $this->lieux_assemblages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * @return Collection|Taille[]
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
            $taille->setArticle($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            // set the owning side to null (unless already changed)
            if ($taille->getArticle() === $this) {
                $taille->setArticle(null);
            }
        }

        return $this;
    }

    public function getNbTailles(): int {
        return $this->tailles->count();
    }

    public function __toString(): string {
        return $this->nom;
    }

    /**
     * @return Collection|Fournisseur[]
     */
    public function getLieuxCoupes(): Collection
    {
        return $this->lieux_coupes;
    }

    public function addLieuxCoupe(Fournisseur $lieuxCoupe): self
    {
        if (!$this->lieux_coupes->contains($lieuxCoupe)) {
            $this->lieux_coupes[] = $lieuxCoupe;
        }

        return $this;
    }

    public function removeLieuxCoupe(Fournisseur $lieuxCoupe): self
    {
        $this->lieux_coupes->removeElement($lieuxCoupe);

        return $this;
    }

    /**
     * @return Collection|Fournisseur[]
     */
    public function getLieuxAssemblages(): Collection
    {
        return $this->lieux_assemblages;
    }

    public function addLieuxAssemblage(Fournisseur $lieuxAssemblage): self
    {
        if (!$this->lieux_assemblages->contains($lieuxAssemblage)) {
            $this->lieux_assemblages[] = $lieuxAssemblage;
        }

        return $this;
    }

    public function removeLieuxAssemblage(Fournisseur $lieuxAssemblage): self
    {
        $this->lieux_assemblages->removeElement($lieuxAssemblage);

        return $this;
    }

    public function getNbNoeud(): ?int
    {
        return $this->nb_noeud;
    }

    public function setNbNoeud(int $nb_noeud): self
    {
        $this->nb_noeud = $nb_noeud;

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->id;
    }

    public function getRefCompta(): ?string
    {
        return $this->ref_compta;
    }

    public function setRefCompta(?string $ref_compta): self
    {
        $this->ref_compta = $ref_compta;

        return $this;
    }
}
