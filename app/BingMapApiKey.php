<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BingMapApiKey extends Model
{
    protected $fillable = [
        'api_key','fetch_order','in_use'
    ];

}
