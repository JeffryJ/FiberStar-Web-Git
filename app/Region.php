<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable=[
        'name'
    ];

    public function subregions(){
        return $this->hasMany('App\SubRegion','region_id','id');
    }
}
