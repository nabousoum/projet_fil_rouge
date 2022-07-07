<?php
namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Service\PrixMenu;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(PrixMenu $prixMenu,EntityManagerInterface $entityManager,FileUploader $file)
    {
        $this->entityManager = $entityManager;
        $this->file = $file;
        $this->prixMenu = $prixMenu;
    }
    public function supports($data): bool
    {
        return $data instanceof Produit;
         
    }
    /**
    * @param Produit $data
    */
    public function persist($data)
    {
        
        $data->setImageBlob($this->file->encode());    
        $im = $this->file->encode();
        $data->setImage($im);      
            if($data instanceof Menu){
                //dd($data->getMenuBurgers()[0]->getBurger()->getId());
              $data->setPrix($this->prixMenu->getPrix($data));
            }
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $data->setEtat("archive");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
