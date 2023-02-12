<?php

namespace App\Entity;

use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TailleRepository::class)
 */
class Taille
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
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="tailles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\OneToMany(targetEntity=UtiliseMP::class, mappedBy="taille", orphanRemoval=true, cascade={"persist"})
     */
    private $utiliseMPs;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite_tissu;

    public function __construct()
    {
        $this->utiliseMPs = new ArrayCollection();
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function __toString() {
        return $this->nom;
    }

    /**
     * @return Collection|UtiliseMP[]
     */
    public function getUtiliseMPs(): Collection
    {
        return $this->utiliseMPs;
    }

    public function addUtiliseMP(UtiliseMP $utiliseMP): self
    {
        if (!$this->utiliseMPs->contains($utiliseMP)) {
            $this->utiliseMPs[] = $utiliseMP;
            $utiliseMP->setTaille($this);
        }

        return $this;
    }

    public function removeUtiliseMP(UtiliseMP $utiliseMP): self
    {
        if ($this->utiliseMPs->removeElement($utiliseMP)) {
            // set the owning side to null (unless already changed)
            if ($utiliseMP->getTaille() === $this) {
                $utiliseMP->setTaille(null);
            }
        }

        return $this;
    }


    /**
     * Return false if MPs is not defined else return true
     * @return bool
     */
    public function getMpDef(): bool {
        if ($this->utiliseMPs[0] == null) return false;
        else return true;
    }

    public function getQuantiteTissu(): ?float
    {
        return $this->quantite_tissu;
    }

    public function setQuantiteTissu(float $quantite_tissu): self
    {
        $this->quantite_tissu = $quantite_tissu;

        return $this;
    }
}
