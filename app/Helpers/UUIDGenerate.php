<?php

namespace App\Helpers;
use App\Wallet;
use App\Transaction;

class UUIDGenerate{
        public static function accountNumber(){

            $number = mt_rand(1111111111111111,9999999999999999);

            if(Wallet::where('account_number',$number)->exists()){
                self::accountNumber();
            };

            return $number;
        }

        public static function refNumber(){

            $number = mt_rand(1111111111111111,9999999999999999);

            if(Transaction::where('ref_no',$number)->exists()){
                self::refNumber();
            };

            return $number;
        }

        public static function trxId(){

            $number = mt_rand(1111111111111111,9999999999999999);

            if(Transaction::where('trx_id',$number)->exists()){
                self::trxid();
            };

            return $number;
        }
    }

?>