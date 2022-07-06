<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonCommandeRepository::class)]
#[ApiResource()]
class BoissonCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: BoissonTailleBoisson::class, inversedBy: 'boissonCommandes')]
    #[Groups(["com:write"])]
    private $boissonTailleBoisson;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonCommandes')]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBoissonTailleBoisson(): ?BoissonTailleBoisson
    {
        return $this->boissonTailleBoisson;
    }

    public function setBoissonTailleBoisson(?BoissonTailleBoisson $boissonTailleBoisson): self
    {
        $this->boissonTailleBoisson = $boissonTailleBoisson;

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
