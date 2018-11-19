<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandingPageData extends Model
{
    protected $fillable =[
        'background_image_link','who_we_are','benefit1_title','benefit1_description','benefit1_image_link','benefit2_title','benefit2_description','benefit2_image_link','benefit3_title','benefit3_description','benefit3_image_link','benefit4_title','benefit4_description','benefit4_image_link'
    ];

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }
}
