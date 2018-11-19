<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_name','description','image_link'
    ];

    public function advantages(){
        return $this->hasMany('App\ServiceAdvantage','service_id','id')->essentials();
    }

    public function scopeEssentials($query){
        $extra = ['id','service_name AS service','image_link  AS image','description as content'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }
}
