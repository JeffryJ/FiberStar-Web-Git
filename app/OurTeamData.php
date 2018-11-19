<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurTeamData extends Model
{
    protected $fillable = [
        'opportunity1','opportunity2','opportunity3'
    ];

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }
}
