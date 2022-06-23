<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "boisson" => "Boisson","portionFrite" => "PortionFrite", "menu" => "Menu", "burger" =>"Burger" ])]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple","burger:read:all"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $image;

    #[ORM\Column(type: 'float')]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:all"])]
    private $etat="disponible";

    #[ORM\Column(type: 'text')]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $description;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private $produitCommandes;

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ProduitCommande>
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }
}
