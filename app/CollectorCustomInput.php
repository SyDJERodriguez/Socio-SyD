<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectorCustomInput extends Model
{
    protected $fillable = [
        'custom_input_id',
        'collector_id',
        'vlaidate'
    ];
}
