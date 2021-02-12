<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomersSession extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customers_session';

    protected $fillable = [
        'client_number', 'email', 'password',
    ];

    protected $hidden = [
        'password'
    ];
}
