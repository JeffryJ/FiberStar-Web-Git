<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'date','description','image_link'
    ];

    protected $dates = [
        'date','created_at','updated_at'
    ];

    public function scopeEssentials($query){
        $extra = ['image_link AS image','date','description AS content'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }
}
