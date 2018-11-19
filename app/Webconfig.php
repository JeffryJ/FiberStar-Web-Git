<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webconfig extends Model
{
    protected $fillable =[
        'logo_image_link','company_name','address','phone','fax','contact_email','customer_care_image_link'
    ];

    public function scopeEssentials($query){
        $data = ['logo_image_link','company_name','address','phone','fax','customer_care_image_link as customer_care'];
        return $query->select($data);
    }
}
