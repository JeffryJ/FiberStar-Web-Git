<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = [
        'kelurahan_id','name'
    ];

    public function kelurahan(){
        $this->belongsTo('App\Kelurahan','kelurahan_id','id');
    }
}
