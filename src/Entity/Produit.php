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
    #[Groups(["burger:read:simple","burger:read:all","write","com:write"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:'le burger ne doit pas etre vide')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])]
    protected $nom;


    #[ORM\Column(type: 'float')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])]
    protected $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:all"])]
    protected $etat="disponible";

    #[ORM\Column(type: 'text')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue:read:simple","complement:read:simple"])] 
    #[Assert\NotBlank(message:'le burger doit avoir une description')]
    protected $description;

    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(["write","burger:read:simple"])]
    protected $image;

    // #[ORM\Column(type: 'blob')]
    #[Groups(["write"])]
    protected $imageBlob;

    public function __construct()
    {

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

    public function getImage()
    {
        return base64_encode(stream_get_contents($this->image));
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
 

    /**
     * Get the value of imageBlob
     */ 
    public function getImageBlob()
    {
        return $this->imageBlob;
    }

    /**
     * Set the value of imageBlob
     *
     * @return  self
     */ 
    public function setImageBlob($imageBlob)
    {
        $this->imageBlob = $imageBlob;

        return $this;
    }
}
