<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[UniqueEntity(fields:'nom',message:'le nom doit etre unique')]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "boisson" => "Boisson","portionFrite" => "PortionFrite", "menu" => "Menu", "burger" =>"Burger" ])]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:'le burger ne doit pas etre vide')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])]
    protected $nom;


    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message:'le burger doit avoir un prix')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])]
    protected $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:all"])]
    protected $etat="disponible";

    #[ORM\Column(type: 'text')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])] 
    #[Assert\NotBlank(message:'le burger doit avoir une description')]
    protected $description;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private $produitCommandes;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;

    // #[ORM\Column(type: 'blob')]
    // #[Groups(["burger:read:simple","burger:read:all","write"])]
    // protected $image;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
 
}
