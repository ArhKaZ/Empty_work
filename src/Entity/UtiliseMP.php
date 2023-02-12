<?php

namespace App\Entity;

use App\Repository\UtiliseMPRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtiliseMPRepository::class)
 */
class UtiliseMP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Taille::class, inversedBy="utiliseMPs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $taille;

    /**
     * @ORM\ManyToOne(targetEntity=MatierePremiere::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $matiere_premiere;

    /**
     * @ORM\Column(type="float")
     */
    private $quantitee;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMatierePremiere(): ?MatierePremiere
    {
        return $this->matiere_premiere;
    }

    public function setMatierePremiere(?MatierePremiere $matiere_premiere): self
    {
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
}
