<?php
namespace App\DataPersister;

use DateTime;
use App\Service\Mailer;
use App\Entity\Commande;
use App\Service\GenererNumCom;
use App\Service\PasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;


class CommandeDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;
    public function __construct(
    EntityManagerInterface $entityManager,
    GenererNumCom $genererNum
    )
    {
        $this->entityManager = $entityManager;
        $this->genererNum = $genererNum;

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
        $data->setNumeroCommande($this->genererNum->genererCom());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  

}
