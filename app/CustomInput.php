<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomInput extends Model
{
    protected $fillable = ['id_field', 'label', 'type'];

    public function collector(){
        return $this->belongsToMany(Collector::class);
    }
}
