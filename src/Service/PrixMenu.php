<?php
namespace App\Service;


class  PrixMenu
{

    public function getPrix($data){
        $prixMenu = 0;
        $burgers = $data->getBurgers();
        $boissons = $data->getTailleBoissons();
        $frites = $data->getPortionFrites();

        foreach($burgers as $burger ){
            $prixMenu += $burger->getPrix();
        }
        foreach($boissons as $boisson ){
            $prixMenu += $boisson->getPrix();
        }
        foreach($frites as $frite ){
            $prixMenu += $frite->getPrix();
        }
      
        return $prixMenu;
    }
}