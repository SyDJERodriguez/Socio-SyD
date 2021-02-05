<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsersBranch extends Authenticatable
{
    use Notifiable;

    protected $guard = 'branch';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password'
    ];
}
