<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['catalogue:read:simple']],
        ]]
)]
class Catalogue
 {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column(type: 'integer')]
    private $id;

   
    #[Groups(["catalogue:read:simple"])]
    private $menus;

   
    #[Groups(["catalogue:read:simple"])]
    private $burgers;

    public function __construct(BurgerRepository $burgerRepo, MenuRepository $menuRepo)
    {
        $this->menus = ["menus"=>$menuRepo->findBy(['etat'=>'disponible'])];
        $this->burgers = ["burgers"=>$burgerRepo->findBy(['etat'=>'disponible'])];
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMenus()
    {
        return $this->menus;
    }


    public function getBurgers()
    {
        return $this->burgers;
    }

    
}
