<?php


namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleBoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $complement;
    public function __construct(BoissonRepository $boissonRepo,PortionFriteRepository $fritesRepo)
    {
      $this->complement = new Complement($fritesRepo,$boissonRepo);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        return[
            $this->complement->getPortionFrites(),
            $this->complement->getTailleBoissons()
        ];
    }
}