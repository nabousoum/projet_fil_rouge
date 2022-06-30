<?php
namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Service\PrixMenu;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

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
        // $im = $data->getImage();
        // dd($image);
        // $imageUpload = $this->file->upload($im);
        // $strm = fopen($this->file,$imageUpload);
        // $imageU = base64_encode(stream_get_contents($image));
        // $data->setImage($imageUpload);
        if($data instanceof Menu){
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
