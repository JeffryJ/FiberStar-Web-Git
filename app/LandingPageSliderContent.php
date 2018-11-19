<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandingPageSliderContent extends Model
{
    protected $fillable = [
        'media_link'
    ];

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }

}
