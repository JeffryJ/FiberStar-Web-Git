<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $fillable=[
        'kecamatan_id','name'
    ];

    public function kecamatan(){
        return $this->belongsTo('App\Kecamatan','kecamatan_id','id');
    }

    public function streets(){
        return $this->hasMany('App\Street','kelurahan_id','id');
    }
}
