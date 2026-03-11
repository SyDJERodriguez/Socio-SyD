<?php


namespace App\Helpers;


use App\Customer;

class CustomersService
{
    public  static function get_mobile_code(){
        //$last_code = Customer::max('phone_validate');
        $time = time();
        $code = Utils::random_id($time);
        return $code;
    }
}