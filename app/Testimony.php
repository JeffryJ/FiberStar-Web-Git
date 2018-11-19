<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    protected $fillable = [
        'name','title','testimony','image_link'
    ];

    public function scopeEssentials($query){
        $extra = ['image_link as image','name','testimony AS testimonial'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }
}
