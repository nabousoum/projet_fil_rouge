<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonTailleBoissonRepository::class)]
#[ApiResource()]
class BoissonTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:all","write","burger:read:simple"])]
    #[Assert\Positive(message:'la quantite doit etre egal au moins a 1')]
    private $quantite=1;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailleBoissons')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissonTailleBoissons')]
    #[Groups(["burger:read:all","write","burger:read:simple"])]
    private $tailleBoisson;

    #[ORM\OneToMany(mappedBy: 'boissonTailleBoisson', targetEntity: BoissonCommande::class)]
    private $boissonCommandes;

    public function __construct()
    {
        $this->boissonCommandes = new ArrayCollection();
    }

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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTailleBoisson(): ?TailleBoisson
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }

    /**
     * @return Collection<int, BoissonCommande>
     */
    public function getBoissonCommandes(): Collection
    {
        return $this->boissonCommandes;
    }

    public function addBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if (!$this->boissonCommandes->contains($boissonCommande)) {
            $this->boissonCommandes[] = $boissonCommande;
            $boissonCommande->setBoissonTailleBoisson($this);
        }

        return $this;
    }

    public function removeBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if ($this->boissonCommandes->removeElement($boissonCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonCommande->getBoissonTailleBoisson() === $this) {
                $boissonCommande->setBoissonTailleBoisson(null);
            }
        }

        return $this;
    }
}
