<?php


namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $burgerRepo;
    private $menuRepo;
    public function __construct(BurgerRepository $burgerRepo,MenuRepository $menuRepo)
    {
      $this->burgerRepo = $burgerRepo;
      $this->menuRepo = $menuRepo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $catalogues=[];
        $catalogues[] = $this->burgerRepo->findBy(['etat'=>'disponible']);
        $catalogues[] = $this->menuRepo->findBy(['etat'=>'disponible']);
        return $catalogues;
        //yield new Catalogue(2);
    }
}