<?php
namespace App\Service;


class  PrixMenu
{

    public function getPrix($data){
        $prixMenu = 0;
        $burgers = $data->getMenuBurgers();

        $boissons = $data->getMenuTailleBoissons();

        $frites = $data->getMenuPortionFrites();

        foreach($burgers as $burger ){
            $prixMenu += $burger->getBurger()->getPrix() * $burger->getQuantite();
        }
        foreach($boissons as $boisson ){
            $prixMenu += $boisson->getTailleBoisson()->getPrix() * $boisson->getQuantite();
        } 
        foreach($frites as $frite ){
            $prixMenu += $frite->getPortionFrite()->getPrix() * $frite->getQuantite();
        }
      
        return $prixMenu;
    }
}