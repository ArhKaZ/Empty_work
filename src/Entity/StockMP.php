<?php

namespace App\Entity;

use App\Repository\StockMPRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockMPRepository::class)
 */
class StockMP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MatierePremiere::class, inversedBy="actionStock")
     * @ORM\JoinColumn(nullable=false)
     * @var MatierePremiere
     */
    private $matiere_premiere;

    /**
     * @ORM\Column(type="float")
     */
    private $quantitee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $origine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatierePremiere(): ?MatierePremiere
    {
        return $this->matiere_premiere;
    }

    public function setMatierePremiere(?MatierePremiere $matiere_premiere): self
    {
        $matiere_premiere->addActionStock($this);
        $this->matiere_premiere = $matiere_premiere;

        return $this;
    }

    public function getQuantitee(): ?float
    {
        return $this->quantitee;
    }

    public function setQuantitee(float $quantitee): self
    {
        $this->quantitee = $quantitee;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function appli(): self
    {
        switch ($this->lieu) {
            case 'MARJORIS':
                $this->matiere_premiere->opStockMarjoris($this->quantitee);
                break;
            case 'SOBELE':
                $this->matiere_premiere->opStockSobele($this->quantitee);
                break;
        }
        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

}
