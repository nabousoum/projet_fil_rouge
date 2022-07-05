<?php
namespace App\Service;


class GenererNumCom
{
    public function genererCom(){
        $today = date("Ymd");
        $rand = sprintf("%04d", rand(0,9999));
        $unique = $today . $rand;
        return $unique;
    }

}