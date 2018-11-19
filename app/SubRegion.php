<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubRegion extends Model
{
    protected $fillable=[
        'region_id','name'
    ];

    public function region(){
        return $this->belongsTo('App\Region','region_id','id');
    }

    public function provinces(){
        return $this->hasMany('App\Province','sub_region_id','id');
    }

}
