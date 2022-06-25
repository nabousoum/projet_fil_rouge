<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionFrites')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
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
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addPortionFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removePortionFrite($this);
        }

        return $this;
    }
}
