<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCollectorDetail extends Model
{
    protected $fillable = [
    'customer_collector_id',
    'custom_input_id',
    'value'
    ];
}
