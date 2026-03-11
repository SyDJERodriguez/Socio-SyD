<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomersSession extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'id','email', 'password'
    ];

    protected $hidden = [
        'password'
    ];
}
