<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterInvitation extends Model
{
    protected $fillable = [
        'email','invite_as_role_id','confirmation_token','invited_by','user_registered'
    ];

    public function role(){
        return $this->belongsTo('App\UserRole','invite_as_role_id','id');
    }

    public function inviter(){
        return $this->belongsTo('App\User','invited_by','id');
    }
}
