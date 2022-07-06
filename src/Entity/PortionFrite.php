<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:simple']],
        ]
    ,"post"=>[
        'method'=>'post',
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['burger:read:all']],
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ]],
    itemOperations:["put"=>[
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        'denormalization_context' => ['groups' => ['write']],
    ],
    "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:all']],
        ],
    "delete"=>[
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        ]
    ],
  
)]
class PortionFrite extends Produit
{

    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $complement;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'portionFrites')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: FriteCommande::class)]
    private $friteCommandes;


    public function __construct()
    {
        parent::__construct();
        $this->menuPortionFrites = new ArrayCollection();
        $this->friteCommandes = new ArrayCollection();
    }


    public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self
    {
        $this->complement = $complement;

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

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection
    {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setPortionFrite($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getPortionFrite() === $this) {
                $menuPortionFrite->setPortionFrite(null);
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
            $friteCommande->setPortionFrite($this);
        }

        return $this;
    }

    public function removeFriteCommande(FriteCommande $friteCommande): self
    {
        if ($this->friteCommandes->removeElement($friteCommande)) {
            // set the owning side to null (unless already changed)
            if ($friteCommande->getPortionFrite() === $this) {
                $friteCommande->setPortionFrite(null);
            }
        }

        return $this;
    }

   
}
