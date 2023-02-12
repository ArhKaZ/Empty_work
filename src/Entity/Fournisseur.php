<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
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
    private $num;

   /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="lieux_coupes")
     */
    private $coupes;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="lieux_assemblages")
     */
    private $assembles;

    /**
     * @ORM\OneToMany(targetEntity=MatierePremiere::class, mappedBy="fournisseur", orphanRemoval=true)
     */
    private $matierePremieres;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;



    public function __construct()
    {
        $this->coupes = new ArrayCollection();
        $this->assembles = new ArrayCollection();
        $this->matierePremieres = new ArrayCollection();
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

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getPortable(): ?string
    {
        return $this->portable;
    }

    public function setPortable(?string $portable): self
    {
        $this->portable = $portable;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
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

    /**
     * @return Collection|Article[]
     */
    public function getCoupes(): Collection
    {
        return $this->coupes;
    }

    public function addCoupe(Article $coupe): self
    {
        if (!$this->coupes->contains($coupe)) {
            $this->coupes[] = $coupe;
            $coupe->addLieuxCoupe($this);
        }

        return $this;
    }

    public function removeCoupe(Article $coupe): self
    {
        if ($this->coupes->removeElement($coupe)) {
            $coupe->removeLieuxCoupe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getAssembles(): Collection
    {
        return $this->assembles;
    }

    public function addAssemble(Article $assemble): self
    {
        if (!$this->assembles->contains($assemble)) {
            $this->assembles[] = $assemble;
            $assemble->addLieuxAssemblage($this);
        }

        return $this;
    }

    public function removeAssemble(Article $assemble): self
    {
        if ($this->assembles->removeElement($assemble)) {
            $assemble->removeLieuxAssemblage($this);
        }

        return $this;
    }

    public function __toString(): string {
        return $this->getNom();
    }

    /**
     * @return Collection|MatierePremiere[]
     */
    public function getMatierePremieres(): Collection
    {
        return $this->matierePremieres;
    }

    public function addMatierePremiere(MatierePremiere $matierePremiere): self
    {
        if (!$this->matierePremieres->contains($matierePremiere)) {
            $this->matierePremieres[] = $matierePremiere;
            $matierePremiere->setFournisseur($this);
        }

        return $this;
    }

    public function removeMatierePremiere(MatierePremiere $matierePremiere): self
    {
        if ($this->matierePremieres->removeElement($matierePremiere)) {
            // set the owning side to null (unless already changed)
            if ($matierePremiere->getFournisseur() === $this) {
                $matierePremiere->setFournisseur(null);
            }
        }

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


    public function getNum()
    {
        return $this->num;
    }


    public function setNum($num): self
    {
        $this->num = $num;
        return $this;
    }


}
