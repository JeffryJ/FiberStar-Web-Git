<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = [
        'volume','image_link'
    ];

    protected $dates = [
        'created_at','updated_at'
    ];

    public function scopeEssentials($query){
        $extra = ['image_link AS volimg','volume','created_at AS dateletter'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);

    }
}
