<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaOutlineHeader extends Model
{
    protected $fillable =[
        'city','kelurahan'
    ];

    public function vertices(){
        return $this->hasMany('App\AreaOutlineVertex','area_outline_header_id','id');
    }
}
