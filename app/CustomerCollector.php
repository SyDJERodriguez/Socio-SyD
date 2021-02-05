<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCollector extends Model
{
    protected $fillable = [
        'customer_id',
        'collector_id',
        'source'
    ];
}
