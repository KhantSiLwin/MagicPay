<?php

use Hashids\Hashids;

function idtohash($id){

    $hashids = new Hashids('magicpay123!@#',8);
    return $hashids->encode($id);

    
}


function hashtoid($hash){
    
    $hashids = new Hashids('magicpay123!@#',8);
    $result = $hashids->decode($hash)[0];

}

?>