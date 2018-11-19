<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurTeamSliderContent extends Model
{
    protected $table = 'our_team_slider_contents';

    protected $fillable = [
        'media_link'
    ];

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }
}
