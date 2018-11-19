<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coverage extends Model
{
    protected $fillable = [
        'place','latitude','longitude','pass_through_type_id'
    ];

    public function type(){
        return $this->belongsTo('App\CoveragePassThroughType','pass_through_type_id','id');
    }

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }
}
