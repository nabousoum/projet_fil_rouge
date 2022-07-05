<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[UniqueEntity(fields:'libelle',message:'le libelle du quartier doit etre unique')]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['quartier:read:simple']],
        "security" => "is_granted('QUARTIER_ALL',_api_resource_class)", 
        ]
    ,"post"=>[
        "security_post_denormalize" => "is_granted('QUARTIER_CREATE', object)",
        'denormalization_context' => ['groups' => ['quartier:write']],
        'normalization_context' => ['groups' => ['quartier:read:all']],
    ]],
    itemOperations:["put"=>[
        "security" => "is_granted('QUARTIER_EDIT', object)" ,
    ],
    "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['quartier:read:all']],
        "security" => "is_granted('QUARTIER_READ', object)",
        ],
    "delete"=>[

        ]
    ],
  
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["quartier:read:all","quartier:write","quartier:read:simple"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:'le libelle  du qurtier ne doit pas etre vide')]
    #[Groups(["quartier:read:all","quartier:write","quartier:read:simple"])]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["quartier:write","quartier:read:simple","quartier:read:all"])]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
