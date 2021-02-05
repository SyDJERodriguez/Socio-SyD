<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected  $fillable = [
        'client_number',
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
        'education',
        'str_branch',
        'state_id',
        'city_id',
        'source',
        'customer_level',
        'collector_id',
        'company',
        'work',
        'job',
        'interest'
    ];




    public function branch(){
    	return $this->belongsTo(Branch::class,'branch_id','id')->select('id', 'name');
    }
    public function branches(){
    	return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function collector(){
        return $this->belongsTo(Collector::class);
    }
    public function origin(){
        return $this->collector()->select('id','name');
    }
}
