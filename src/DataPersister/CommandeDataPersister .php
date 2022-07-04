<?php
namespace App\DataPersister;

use DateTime;
use App\Service\Mailer;
use App\Entity\Commande;
use App\Service\PasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class CommandeDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;
    public function __construct(
    EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;

    }
    public function supports($data): bool
    {
        return $data instanceof Commande;
    }
    /**
    * @param Commande $data
    */
    public function persist($data)
    {
       // $data->setDateCommande(new \DateTime('now') );
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  

}
