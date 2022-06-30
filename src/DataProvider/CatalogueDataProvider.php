<?php


namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $catalogue;
    public function __construct(BurgerRepository $burgerRepo, MenuRepository $menuRepo)
    {
      $this->catalogue = new Catalogue($burgerRepo,$menuRepo);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
       
        return [
            $this->catalogue->getBurgers(),
            $this->catalogue->getMenus()
        ];
        //yield new Catalogue(2);
    }
}