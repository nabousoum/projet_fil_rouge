<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['com:read:all']],
        ],
        "post_register" => [
        "method"=>"post",
        'normalization_context' => ['groups' => ['com:read:simple']],
        'denormalization_context' => ['groups' => ['com:write']]
        ]
        ],itemOperations:["put",
            "get"=>[
                'method' => 'get',
                'status' => Response::HTTP_OK,
                'normalization_context' => ['groups' => ['com:read:all']]
            ]
        ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:read:simple","com:read:all"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["com:read:simple","com:read:all"])]
    private $dateCommande;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all"])]
    private $etat="en cours";

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $montantCommande;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["com:write"])]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonCommande::class)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $boissonCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: FriteCommande::class)]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    private $friteCommandes;



    public function __construct()
    {
        $this->dateCommande = new \DateTime();
        $this->burgerCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->boissonCommandes = new ArrayCollection();
        $this->friteCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

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

    public function getMontantCommande(): ?string
    {
        return $this->montantCommande;
    }

    public function setMontantCommande(string $montantCommande): self
    {
        $this->montantCommande = $montantCommande;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
            }
        }

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
            $boissonCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if ($this->boissonCommandes->removeElement($boissonCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonCommande->getCommande() === $this) {
                $boissonCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriteCommande>
     */
    public function getFriteCommandes(): Collection
    {
        return $this->friteCommandes;
    }

    public function addFriteCommande(FriteCommande $friteCommande): self
    {
        if (!$this->friteCommandes->contains($friteCommande)) {
            $this->friteCommandes[] = $friteCommande;
            $friteCommande->setCommande($this);
        }

        return $this;
    }

    public function removeFriteCommande(FriteCommande $friteCommande): self
    {
        if ($this->friteCommandes->removeElement($friteCommande)) {
            // set the owning side to null (unless already changed)
            if ($friteCommande->getCommande() === $this) {
                $friteCommande->setCommande(null);
            }
        }

        return $this;
    }

   
}
