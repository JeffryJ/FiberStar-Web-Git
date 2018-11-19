<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsCC extends Model
{
    protected $table = 'contact_us_ccs';

    protected $fillable=[
        'email'
    ];
}
