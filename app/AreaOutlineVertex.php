<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaOutlineVertex extends Model
{
    protected $table = "area_outline_vertices";

    protected $fillable=[
        'area_outline_header_id','latitude','longitude','vertex_no'
    ];

    public function header(){
        return $this->belongsTo('App\AreaOutlineHeader','area_outline_header_id','id');
    }
}
