<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientsUpdatedSent extends Model
{
    protected $fillable = [
        'client_number',
        'updated_date'
    ];
}
