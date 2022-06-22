<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitCommandeRepository::class)]
#[ApiResource]
class ProduitCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $qteProduit;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'produitCommandes')]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'produitCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteProduit(): ?string
    {
        return $this->qteProduit;
    }

    public function setQteProduit(string $qteProduit): self
    {
        $this->qteProduit = $qteProduit;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
