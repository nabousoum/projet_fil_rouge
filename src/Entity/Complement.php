<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleBoissonRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['complement:read:simple']],
        ]]
)]
class Complement
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    private $id;

   
    #[Groups(["catalogue:read:simple"])]
    private $portionFrites;

    
    #[Groups(["catalogue:read:simple"])]
    private $tailleBoissons;

    public function __construct(PortionFriteRepository $fritesRepo,BoissonRepository $tailleRepo)
    {
        $this->portionFrites = ["portionsFrites"=>$fritesRepo->findBy(['etat'=>'disponible'])];
        $this->tailleBoissons = ["boissons"=>$tailleRepo->findBy(['etat'=>'disponible'])];
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPortionFrites()
    {
        return $this->portionFrites;
    }


    public function getTailleBoissons()
    {
        return $this->tailleBoissons;
    }

   
}
