<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=CommandeClient::class, mappedBy="num_facture")
     */
    private $prod_achete;

    public function __construct()
    {
        $this->prod_achete = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

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

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|commandeclient[]
     */
    public function getProdAchete(): Collection
    {
        return $this->prod_achete;
    }

    public function addProdAchete(commandeclient $prodAchete): self
    {
        if (!$this->prod_achete->contains($prodAchete)) {
            $this->prod_achete[] = $prodAchete;
            $prodAchete->setNumFacture($this);
        }

        return $this;
    }

    public function removeProdAchete(commandeclient $prodAchete): self
    {
        if ($this->prod_achete->removeElement($prodAchete)) {
            // set the owning side to null (unless already changed)
            if ($prodAchete->getNumFacture() === $this) {
                $prodAchete->setNumFacture(null);
            }
        }

        return $this;
    }
}
