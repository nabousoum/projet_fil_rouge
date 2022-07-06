<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
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
        'denormalization_context' => ['groups' => ['write']],
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
class Boisson extends Produit
{
  

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'boissons')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTailleBoisson::class,cascade:['persist'])]
    #[Groups(["burger:read:simple","burger:read:all","write"])]
    #[Assert\Valid]
    #[Assert\Count(min:1,minMessage:'la boisson doit avoir une taille')]
    private $boissonTailleBoissons;


    public function __construct()
    {
        $this->boissonTailleBoissons = new ArrayCollection();
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
            $boissonTailleBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTailleBoisson(BoissonTailleBoisson $boissonTailleBoisson): self
    {
        if ($this->boissonTailleBoissons->removeElement($boissonTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleBoisson->getBoisson() === $this) {
                $boissonTailleBoisson->setBoisson(null);
            }
        }

        return $this;
    }

    
}
