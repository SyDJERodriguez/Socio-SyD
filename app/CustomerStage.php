<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerStage extends Model
{
    protected $fillable = ['customer_id','stage'];
}
