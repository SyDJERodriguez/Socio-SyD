<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $fillable = [
        'name',
        'title',
        'redirect_to',
        'style',
        'head',
        'body_code',
        'footer_code',
        'type',
        'source',
        'source_key',
    ];

    public function custom_inputs(){
        return $this->belongsToMany(CustomInput::class,'collector_custom_inputs');
    }
}
