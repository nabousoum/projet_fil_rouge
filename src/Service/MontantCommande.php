<?php
namespace App\Service;


class  MontantCommande
{
    public function calculMontantCommande($data){
       
       $montantCommande = $prixZone = $data->getZone()->getPrix();

        $burgers = $data->getBurgerCommandes();
        $boissons = $data->getBoissonCommandes();
        $frites = $data->getFriteCommandes();

        foreach($burgers as $burger ){
            $burger->setPrix($burger->getBurger()->getPrix() * $burger->getQuantite());
            $montantCommande += $burger->getBurger()->getPrix() * $burger->getQuantite();
        }

        foreach($boissons as $boisson ){
            $boisson->setPrix($boisson->getBoissonTailleBoisson()->getTailleBoisson()->getPrix() * $boisson->getQuantite());
            $montantCommande += $boisson->getBoissonTailleBoisson()->getTailleBoisson()->getPrix() * $boisson->getQuantite();
        }

        foreach($frites as $frite ){
            $frite->setPrix($frite->getPortionFrite()->getPrix() * $frite->getQuantite());
            $montantCommande += $frite->getPortionFrite()->getPrix() * $frite->getQuantite();
        }
        return $montantCommande;
    }


}