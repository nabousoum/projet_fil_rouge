<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource]
class PortionFrite extends Produit
{


    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'portionFrites')]
    #[ORM\JoinColumn(nullable: false)]
    private $complement;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'portionFrites')]
    private $gestionnaire;


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
}
