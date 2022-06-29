<?php


namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $boissonRepo;
    private $fritesRepo;
    public function __construct(TailleBoissonRepository $boissonRepo,PortionFriteRepository $fritesRepo)
    {
      $this->boissonRepo = $boissonRepo;
      $this->fritesRepo = $fritesRepo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $complements=[];
        $complements[] = $this->boissonRepo->findAll();
        $complements[] = $this->fritesRepo->findAll();
        return $complements;
        //yield new Catalogue(2);
    }
}