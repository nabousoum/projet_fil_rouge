<?php
namespace App\DataPersister;

use DateTime;
use App\Entity\User;
use App\Entity\Client;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordHasherInterface
    $passwordHasher;
    private EntityManagerInterface $entityManager;
    public function __construct(UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $entityManager, Mailer $mailer,
    )
    {
        $this->passwordHasher= $passwordHasher;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;

    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }
    /**
    * @param User $data
    */
    public function persist($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
        $data,
        $data->getPassword()
        );
        $data->setPassword($hashedPassword);
        $data->setToken($this->generateToken());
        $data->setRoles(["ROLE_CLIENT"]);
        $data->setExpiredAt(new \DateTime('+1 days'));
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        $this->mailer->sendEmail($data->getLogin(), $data->getToken());
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
