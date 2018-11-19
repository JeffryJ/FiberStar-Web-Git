<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable=[
        'sub_region_id','province_id'
    ];

    public function subregion(){
        return $this->belongsTo('App\SubRegion','sub_region_id','id');
    }

    public function cities(){
        return $this->hasMany('App\City','province_id','id');
    }

}
