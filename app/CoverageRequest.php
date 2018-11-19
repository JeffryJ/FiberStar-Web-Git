<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverageRequest extends Model
{
    protected $fillable = [
        'name','phone_no','email','city','district','subdistrict','postal_code','street','latitude','longitude','reviewed'
    ];
}
