<?php
namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class  PasswordHasher
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher=$passwordHasher;
    }
    public function passwordHash($data){
        
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
            );
        return $hashedPassword;
    }

}