<?php


namespace App\Http\Controllers\vue;


use App\Customer;
use App\Http\Controllers\Controller;
use App\VueTables\EloquentVueTables;

class VueCustomerController extends Controller
{
    public function getCustommersJSON($type){
        $vueTables = new EloquentVueTables();
        $data = $vueTables->get(new Customer, ['id','client_number',
            'name',
            'last_name',
            'second_last_name',
            'email',
            'mobile_number',
            'created_at',
            'updated_at',
            'branch_id',
            'is_new',
            'email_validate',
            'phone_validate',
            'gender',
            'phone',
            'birthday',
            'client_type',
            'street',
            'colonia',
            'postal_code',
            'city_id',
            'state_id',
            'education'],['branch'],$type);

        return response()->json($data);
    }

    public function getCustommerJSON(Customer $customer){
        return $customer;
    }
}
