<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAdvantage extends Model
{
    protected $fillable=[
        'service_id','advantage'
    ];

    public function service(){
        return $this->belongsTo('App\Service','servicce_id','id');
    }

    public function scopeEssentials($query){
        $extra = ['id'];
        return $query->select(array_merge($extra,$this->getFillable()));
    }
}
