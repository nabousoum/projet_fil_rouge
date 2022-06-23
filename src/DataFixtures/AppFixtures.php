<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher){
      
        $this->passwordHasher = $passwordHasher ;
    }

    public function load(ObjectManager $manager): void
    {
        //$user=new User();
        $user=new Client();
        $user->setLogin('client@gmail.com');
        $user->setNom('thiam');
        $user->setPrenom('seydou');
        $user->setAdresse("mbao");
        $user->setTelephone("778339159");
        $hashedPassword = $this->passwordHasher->hashPassword(
        $user,
        'passer'
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_CLIENT']);
        //$user1=new User();
        $user1=new Gestionnaire();
        $user1->setLogin('gestionnaire@gmail.com');
        $user1->setNom('soumare');
        $user1->setPrenom('seynabou');
        $hashedPassword = $this->passwordHasher->hashPassword(
        $user1,
        'passer'
        );
        $user1->setPassword($hashedPassword);
        $user1->setRoles(['ROLE_GESTIONNAIRE']);
        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}
