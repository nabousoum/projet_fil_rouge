<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:simple']],
        ]
    ,"post"=>[
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['burger:read:all']],
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ]],
    itemOperations:["put"=>[
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
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
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["write","com:write"])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["burger:read:simple","burger:read:all","write","complement:read:simple"])]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:simple","burger:read:all","write","complement:read:simple"])]
    private $libelle;


    #[Groups(["burger:read:simple","burger:read:all","write"])]
    private $complement;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: BoissonTailleBoisson::class)]
    #[Groups(["com:write"])]
    private $boissonTailleBoissons;

    public function __construct()
    {
        $this->menuTailleBoissons = new ArrayCollection();
        $this->boissonTailleBoissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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

    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailleBoissons(): Collection
    {
        return $this->menuTailleBoissons;
    }

    public function addMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if (!$this->menuTailleBoissons->contains($menuTailleBoisson)) {
            $this->menuTailleBoissons[] = $menuTailleBoisson;
            $menuTailleBoisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getTailleBoisson() === $this) {
                $menuTailleBoisson->setTailleBoisson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTailleBoisson>
     */
    public function getBoissonTailleBoissons(): Collection
    {
        return $this->boissonTailleBoissons;
    }

    public function addBoissonTailleBoisson(BoissonTailleBoisson $boissonTailleBoisson): self
    {
        if (!$this->boissonTailleBoissons->contains($boissonTailleBoisson)) {
            $this->boissonTailleBoissons[] = $boissonTailleBoisson;
            $boissonTailleBoisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTailleBoisson(BoissonTailleBoisson $boissonTailleBoisson): self
    {
        if ($this->boissonTailleBoissons->removeElement($boissonTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleBoisson->getTailleBoisson() === $this) {
                $boissonTailleBoisson->setTailleBoisson(null);
            }
        }

        return $this;
    }
}
