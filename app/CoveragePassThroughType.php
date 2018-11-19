<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoveragePassThroughType extends Model
{
    protected $fillable = [
        'pass_thorugh_type'
    ];

    public function coverages(){
        return $this->hasMany('App\Coverage','pass_through_type_id','id');
    }
}
