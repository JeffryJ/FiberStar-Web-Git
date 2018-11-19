<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUsData extends Model
{
    protected $fillable = [
        'vision','mission','corporate_values_description','corporate_values_image_link'
    ];

    public function scopeEssentials($query){
        $extra = ['corporate_values_image_link AS imagestar','corporate_values_description AS boxtwo','vision','mission'];
        return $query->select($extra);
    }

}
