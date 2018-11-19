<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=[
        'province_id','name'
    ];

    public function province(){
        return $this->belongsTo('App\Province','province_id','id');
    }

    public function kecamatans(){
        return $this->hasMany('App\Kecamatan','city_id','id');
    }
}
