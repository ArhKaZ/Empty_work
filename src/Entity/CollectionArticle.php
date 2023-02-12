<?php

namespace App\Entity;

use App\Repository\CollectionArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CollectionArticleRepository::class)
 * @UniqueEntity("nom")
 */
class CollectionArticle implements \JsonSerializable
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
     * @ORM\ManyToMany(targetEntity=Taille::class, cascade={"persist"})
     */
    private $tailles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motifFilename;

    /**
     * @ORM\ManyToOne(targetEntity=MatierePremiere::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tissu;

    /**
     * @ORM\ManyToOne(targetEntity=MatierePremiere::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $couleur_noeud;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

        return $this;
    }

    public function getNbProduit(): int
    {
        return $this->tailles->count();
    }

    public function getMotifFilename(): ?string
    {
        return $this->motifFilename;
    }

    public function setMotifFilename(string $motifFilename): self
    {
        $this->motifFilename = $motifFilename;

        return $this;
    }

    public function getTissu(): ?MatierePremiere
    {
        return $this->tissu;
    }

    public function setTissu(?MatierePremiere $tissu): self
    {
        $this->tissu = $tissu;

        return $this;
    }

    public function getCouleurNoeud(): ?MatierePremiere
    {
        return $this->couleur_noeud;
    }

    public function setCouleurNoeud(?MatierePremiere $couleur_noeud): self
    {
        $this->couleur_noeud = $couleur_noeud;

        return $this;
    }

    public function __toString(): string {
        return $this->getNom();
    }

    public function jsonSerialize() {
        return $this->id;
    }
}
